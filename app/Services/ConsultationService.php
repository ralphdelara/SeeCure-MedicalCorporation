<?php

namespace App\Services;

use App\Enums\SignsOrSymptomEnum;
use App\Enums\VisitStatusEnum;
use App\Events\ConsultationViewed;
use App\Events\SignsOrSymptomsSaved;
use App\Models\Consultation;
use App\Models\ConsultationAudit;
use App\Models\ConsultationDiagnosis;
use App\Models\ConsultationDiagnosisIcd10Code;
use App\Models\ConsultationSoap;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ConsultationService
{
    public function getConsultationList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $consultationList = Consultation::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
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
            'guardianRelationship' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign' => function ($query) {
                $query->select('id', 'consultation_id', 'vital_sign_id', 'vital_sign_field_id', 'value');
            },
            'patientVitalSign.vitalSign' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign.vitalSignField' => function ($query) {
                $query->select('id', 'name', 'unit');
            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'status',
            'signsOrSymptoms',
            'doctor.professions',
            'doctor.specialties',
        ]);

        if (! empty($keyword)) {
            $consultationList = $consultationList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        $consultationList = $consultationList->orderBy('created_at')->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $consultationList->collect()->toArray();
        $pageData = Arr::except($consultationList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($consultationList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function getConsultationDetails(string $consultationId): ?array
    {
        $consultation = Consultation::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
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
            'guardianRelationship' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign' => function ($query) {
                $query->select('id', 'consultation_id', 'vital_sign_id', 'vital_sign_field_id', 'value');
            },
            'patientVitalSign.vitalSign' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign.vitalSignField' => function ($query) {
                $query->select('id', 'name', 'unit');
            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'status',
            'signsOrSymptoms',
            'soap',
            'diagnosis',
            'diagnosis.icd10Codes',
            'diagnosis.icd10Codes.icd10Code',
            'prescriptions',
            'prescriptions.createdBy',
            'prescriptions.createdBy.professions',
            'prescriptions.createdBy.specialties',
            'prescriptions.lastModifiedBy',
            'prescriptions.lastModifiedBy.professions',
            'prescriptions.lastModifiedBy.specialties',
        ])->find($consultationId);

        if (empty($consultation)) {
            abort(404);
        }

        ConsultationViewed::dispatch($consultation);

        return $consultation->toArray();
    }

    public function storeConsultation(
        string $visitId,
        string $patientId,
        array $consultDetails,
    ): string {
        $consultation = Consultation::create([
            'visit_id'                 => $visitId,
            'patient_id'               => $patientId,
            'guardian_name'            => $consultDetails['guardian_name'],
            'guardian_contact_number'  => $consultDetails['guardian_contact_number'],
            'guardian_email'           => $consultDetails['guardian_email'],
            'guardian_relationship_id' => $consultDetails['guardian_relationship_id'],
            'status_id'                => 1, // Pending
            'doctor_id'                => $consultDetails['doctor_id'],
            'created_by'               => Auth::id(),
            'last_modified_by'         => Auth::id(),
        ]);

        // insert signs or symptoms
        $this->updateRelatedData(
            $consultation,
            $consultDetails['signs_or_symptoms_id'],
            $consultation->id,
        );

        ConsultationSoap::create([
            'consultation_id'  => $consultation->id,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        ConsultationDiagnosis::create([
            'consultation_id'  => $consultation->id,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        return (string) $consultation->id;
    }

    public function getPendingConsultationList(): array
    {
        return Visit::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'signsOrSymptoms',
            'doctor.professions',
        ])->whereVisitStatusId(VisitStatusEnum::IN_CONSULTATION)->get()->toArray();
    }

    public function updateDetails(array $details): void
    {
        $id = $details['id'];

        unset($details['id']);

        $details['last_modified_by'] = Auth::id();

        $consultation = Consultation::find($id);
        $consultation->update($details);

        $this->updateRelatedData($consultation, $details['signs_or_symptoms_id'], $id);
    }

    public function updateSoap(array $soapDetails): void
    {
        $id = $soapDetails['id'];

        unset($soapDetails['id']);

        $soapDetails['last_modified_by'] = Auth::id();

        ConsultationSoap::find($id)->update($soapDetails);
    }

    public function updateDiagnosis(array $diagnosisDetails): void
    {
        $icd10Ids = $diagnosisDetails['icd10Ids'];

        $id = $diagnosisDetails['id'];

        unset($diagnosisDetails['id']);
        unset($diagnosisDetails['icd10Ids']);

        $diagnosisDetails['last_modified_by'] = Auth::id();

        $consultationDiagnosis = ConsultationDiagnosis::with('icd10Codes')->find($id);
        $consultationDiagnosis->update($diagnosisDetails);

        // add or update profession data
        updateRelatedData(
            new ConsultationDiagnosisIcd10Code,
            $consultationDiagnosis->icd10Codes->pluck('id')->toArray(),
            $icd10Ids,
            $id,
            'consultation_diagnosis_id',
            'icd10_code_id',
        );
    }

    public function addOrUpdatePrescription(array $prescriptionDetails): void
    {
        $id = $prescriptionDetails['id'];

        unset($prescriptionDetails['id']);
        unset($prescriptionDetails['created_by']);

        if (empty($id)) {
            $prescriptionDetails['created_by'] = Auth::id();
        }

        $prescriptionDetails['last_modified_by'] = Auth::id();

        Prescription::updateOrCreate(
            ['id' => $id],
            $prescriptionDetails,
        );
    }

    public function getAuditLog(string $consultationId): array
    {
        return ConsultationAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('consultation_id', $consultationId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }

    public function updateRelatedData(
        Consultation $consultation,
        array $signsOrSymptomIds,
        string $consultationId,
    ): void {
        $signsOrSymptomAudit = $consultation->signsOrSymptoms()->sync($signsOrSymptomIds);

        if (
            ! empty($signsOrSymptomAudit['attached'])
            || ! empty($signsOrSymptomAudit['detached'])
        ) {
            SignsOrSymptomsSaved::dispatch(
                getRelatedAuditFields(
                    SignsOrSymptomEnum::getDescriptionLists(),
                    $signsOrSymptomAudit,
                ),
                $consultationId,
            );
        }
    }
}
