<?php

namespace App\Services;

use App\Models\Consultation;
use Arr;
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
                $query->select('id', 'first_name', 'last_name', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            },
            'patientVitalSign' => function ($query) {
                $query->select('id', 'vital_sign_id', 'vital_sign_field_id', 'value');
            },
            'patientVitalSign.vitalSign' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign.vitalSignField' => function ($query) {
                $query->select('id', 'name');
            },
            'signsOrSymptoms.signsOrSymptom' => function ($query) {
                $query->select('id', 'name');
            },
            'types.type' => function ($query) {
                $query->select('id', 'name');
            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            },
            'doctor.professions.profession' => function ($query) {
                $query->select('id', 'name', 'prefix', 'suffix');
            },
            'status' => function ($query) {
                $query->select('id', 'name');
            },
        ])->orderBy('created_at')->paginate(50)
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

    public function getConsultationDetails(int $id): ?array
    {
        $consultation = Consultation::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            },
            'patientVitalSign' => function ($query) {
                $query->select('id', 'consultation_id', 'vital_sign_id', 'vital_sign_field_id', 'value');
            },
            'patientVitalSign.vitalSign' => function ($query) {
                $query->select('id', 'name');
            },
            'patientVitalSign.vitalSignField' => function ($query) {
                $query->select('id', 'name');
            },
            'signsOrSymptoms.signsOrSymptom' => function ($query) {
                $query->select('id', 'name');
            },
            'types.type' => function ($query) {
                $query->select('id', 'name');
            },
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            },
            'doctor.professions.profession' => function ($query) {
                $query->select('id', 'name', 'prefix', 'suffix');
            },
            'status' => function ($query) {
                $query->select('id', 'name');
            },
            'guardianRelationship' => function ($query) {
                $query->select('id', 'name');
            },
        ])->find($id)?->toArray();

        if (empty($consultation)) {
            abort(404);
        } else {
            return $consultation;
        }
    }

    public function createConsultation(
        int $visitId,
        int $patientId,
        array $consultDetails,
    ): int {

        $consultation = Consultation::create([
            'visit_id'                => $visitId,
            'patient_id'              => $patientId,
            'guardian_name'           => $consultDetails['guardian_name'],
            'guardian_contact_number' => $consultDetails['guardian_contact_number'],
            'guardian_email'          => $consultDetails['guardian_email'],
            'status_id'               => 1, // Pending
            'doctor_id'               => $consultDetails['doctor_id'],
            'created_by'              => Auth::id(),
        ]);

        // insert signs or symptoms
        $data = array_map(fn ($id) => [
            'consultation_id'     => $consultation->id,
            'signs_or_symptom_id' => $id,
        ], $consultDetails['signs_or_symptoms_id']);
        $consultation->signsOrSymptoms()->insert($data);

        return $consultation->id;
    }
}
