<?php

namespace App\Services;

use App\Events\PatientViewed;
use App\Models\Barangay;
use App\Models\City;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Patient;
use App\Models\PatientAudit;
use App\Models\PatientSuffix;
use App\Models\Province;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientService
{
    public function getPatientList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $patientList = Patient::with([
            'gender',
            'suffix',
            'status',
            'province',
            'city',
            'barangay',
            'civilStatus',
            'nationality',
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'lastModifiedBy.professions',
            'lastModifiedBy.specialties',
            'lastModifiedBy',
        ]);

        if (! empty($keyword)) {
            $patientList = $patientList->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
        }

        $patientList = $patientList->orderBy('batch')
            ->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $patientList->collect()->toArray();
        $pageData = Arr::except($patientList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($patientList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function addOrUpdatePatient(array $patientDetails): Patient
    {
        $patientId = $patientDetails['patient_id'];

        unset($patientDetails['patient_id']);

        $patientDetails['status_id'] = 1; // Waiting

        $patientDetails['last_name'] = formatName($patientDetails['last_name']);
        $patientDetails['first_name'] = formatName($patientDetails['first_name']);

        $patientDetails['last_name_index'] = $patientDetails['last_name'];
        $patientDetails['first_name_index'] = $patientDetails['first_name'];

        if (! empty($patientDetails['middle_name'])) {
            $patientDetails['middle_name'] = formatName($patientDetails['middle_name']);
            $patientDetails['middle_name_index'] = $patientDetails['middle_name'];
        }

        if (empty($patientId)) {
            $patientDetails['created_by'] = Auth::id();
        }

        $patientDetails['last_modified_by'] = Auth::id();

        $patient = Patient::updateOrCreate(
            ['id' => $patientId],
            $patientDetails,
        );

        $this->updatePatientOrder();

        return $patient;
    }

    public function updatePatientOrder(): void
    {
        $patients = Patient::select('id', 'last_name', 'first_name', 'middle_name')->get()->toArray();

        usort($patients, function ($a, $b) {
            return strcasecmp($a['last_name'], $b['last_name'])
                ?: strcasecmp($a['first_name'], $b['first_name'])
                ?: strcasecmp($a['middle_name'], $b['middle_name']);
        });

        $sequenceNo = 1; // Renamed for accurate code readability

        DB::transaction(function () use ($patients, &$sequenceNo) {
            $chunks = array_chunk($patients, 2000);

            foreach ($chunks as $chunk) {
                $cases = [];
                $ids = [];
                $params = [];

                foreach ($chunk as $index => $patient) {
                    // ::bigint casting to explicitly satisfy PostgreSQL's strict type system
                    $cases[] = "WHEN id = :id{$index} THEN :batch{$index}::bigint";
                    $ids[] = ":id{$index}";

                    $params["id{$index}"] = $patient['id'];
                    $params["batch{$index}"] = $sequenceNo;
                    $sequenceNo++; // Increments on every single row item
                }

                $caseSql = implode(' ', $cases);
                $idSql = implode(',', $ids);

                $sql = "UPDATE patients SET batch = CASE {$caseSql} END WHERE id IN ({$idSql})";
                DB::update($sql, $params);
            }
        });
    }

    public function getPatientFormOptions(): array
    {
        $genderOptions = Gender::all();
        $nationalityOptions = Nationality::all();
        $civilStatusOptions = CivilStatus::all();
        $suffixOptions = PatientSuffix::all();
        $provinceOptions = Province::all();
        $cityOptions = City::select('id', 'name')->where('province_id', '=', 1)->get(); // Aklan
        $barangayOptions = Barangay::select('id', 'name')->where('province_id', '=', 16)->get(); // Numancia

        return compact(
            'genderOptions',
            'civilStatusOptions',
            'nationalityOptions',
            'suffixOptions',
            'provinceOptions',
            'cityOptions',
            'barangayOptions',
        );
    }

    public function getPatientDetails(string $id): array
    {
        abortIfInvalidUuid($id);

        $patient = Patient::with([
            'gender',
            'suffix',
            'status',
            'province',
            'city',
            'barangay',
            'civilStatus',
            'nationality',
            'visits',
            // consultation
            'visits.consultation',
            'visits.consultation.soap',
            'visits.consultation.diagnosis',
            'visits.consultation.diagnosis.icd10Codes.icd10Code',
            'visits.consultation.prescriptions',
            'visits.consultation.doctor.professions',
            'visits.consultation.doctor.specialties',
            'visits.consultation.signsOrSymptoms',
            'visits.consultation.guardianRelationship',
            'visits.consultation.vitalSigns.vitalSign',
            'visits.consultation.vitalSigns.vitalSignField',
            'visits.consultation.vitalSigns.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visits.consultation.vitalSigns.createdBy.professions',
            'visits.consultation.vitalSigns.createdBy.specialties',
            'visits.consultation.vitalSigns.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visits.consultation.vitalSigns.lastModifiedBy.professions',
            'visits.consultation.vitalSigns.lastModifiedBy.specialties',
            // laboratory
            'visits.laboratory.remarks',
            'visits.laboratory.testData',
            'visits.laboratory.testData.type',
            'visits.laboratory.testData.test',
            'visits.laboratory.testData.fields' => function ($query) {
                $query->orderBy('id');
            },
            'visits.laboratory.testData.fields.field',
            'visits.laboratory.performedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visits.laboratory.performedBy.professions',
            'visits.laboratory.performedBy.specialties',
            'visits.laboratory.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visits.laboratory.createdBy.professions',
            'visits.laboratory.createdBy.specialties',
            'visits.laboratory.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visits.laboratory.lastModifiedBy.professions',
            'visits.laboratory.lastModifiedBy.specialties',
            // radiology
            'visits.radiology',
            'visits.createdBy',
            'visits.createdBy.professions',
            'visits.createdBy.specialties',
            'visits.priorityTypes',
            'visits.status',
            'vitalSigns',
            'audits',
            'documents',
            'documents.type',
            'documents.files',
            'documents.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'documents.createdBy.professions',
            'documents.createdBy.specialties',
            'documents.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'documents.lastModifiedBy.professions',
            'documents.lastModifiedBy.specialties',
        ])->find($id);

        if (empty($patient)) {
            abort(404);
        }

        PatientViewed::dispatch($patient);

        return $patient->toArray();
    }

    public function getSmallPatientList(?string $keyword): array
    {
        $patient = Patient::with([
            'gender',
            'suffix',
            'province',
            'city',
            'barangay',
            'civilStatus',
        ])
            ->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'gender_id', 'barangay_id', 'city_id', 'province_id');

        if (! empty($keyword)) {
            $patient = $patient->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
        }

        $patient = $patient
            ->limit(15)
            ->orderBy('batch')
            ->get();

        return $patient->toArray();
    }

    public function getAuditLog(string $patientId): array
    {
        return PatientAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }
}
