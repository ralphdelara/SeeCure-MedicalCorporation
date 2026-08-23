<?php

namespace App\Services;

use App\Models\Barangay;
use App\Models\City;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Patient;
use App\Models\PatientSuffix;
use App\Models\Province;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientService
{
    public function getPatientList(
        ?string $keyword,
        ?string $selectId,
        string $path,
    ): array {
        $patientList = Patient::with(['gender', 'suffix', 'status', 'province', 'city', 'barangay', 'civilStatus', 'nationality']);

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

    public function addOrUpdatePatient(array $patientDetails): string
    {
        $patientId = $patientDetails['patient_id'];

        unset($patientDetails['patient_id']);

        $patientDetails['status_id'] = 1; // Waiting
        $patientDetails['created_by'] = Auth::id();

        $patientDetails['last_name'] = formatName($patientDetails['last_name']);
        $patientDetails['first_name'] = formatName($patientDetails['first_name']);

        $patientDetails['last_name_index'] = $patientDetails['last_name'];
        $patientDetails['first_name_index'] = $patientDetails['first_name'];

        if (! empty($patientDetails['middle_name'])) {
            $patientDetails['middle_name'] = formatName($patientDetails['middle_name']);
            $patientDetails['middle_name_index'] = $patientDetails['middle_name'];
        }

        $patient = Patient::updateOrCreate(
            ['id' => $patientId],
            $patientDetails,
        );

        $this->updatePatientOrder();

        return (string) $patient->id;
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
        // for postgresql, mysql doesnt need this
        if (! Str::isUuid($id)) {
            abort(404);
        }

        $patient = Patient::with([
            'gender',
            'suffix',
            'status',
            'province',
            'city',
            'barangay',
            'consultation',
            'laboratory',
            'civilStatus',
            'nationality',
            'patientAudit',
        ])->find($id);

        if (empty($patient)) {
            abort(404);
        }

        return $patient->toArray();
    }
}
