<?php

namespace App\Services;

use App\Enums\SignsOrSymptomEnum;
use App\Enums\VisitStatusEnum;
use App\Events\ConsultationViewed;
use App\Events\Icd10CodeSaved;
use App\Events\SignsOrSymptomsSaved;
use App\Models\Consultation;
use App\Models\ConsultationAudit;
use App\Models\ConsultationSoap;
use App\Models\Diagnosis;
use App\Models\DiagnosisIcd10Code;
use App\Models\Icd10Code;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\PatientVitalSign;
use App\Models\Prescription;
use App\Models\Radiology;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ConsultationService
{
    public function getConsultationList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $consultationList = Consultation::with([
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
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
            'signsOrSymptoms',
            'doctor.professions',
            'doctor.specialties',
            'visit',
        ]);

        if (! empty($keyword)) {
            $consultationList = $consultationList->whereHas('visit.patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
            });
        }

        if ($status === 'completed') {
            $consultationList = $consultationList->where('is_completed', true);
        } else {
            $consultationList = $consultationList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_CONSULTATION)
                    ->where('is_completed', false);
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
        abortIfInvalidUuid($consultationId);

        $consultation = Consultation::with([
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
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
            'patientVitalSign.createdBy',
            'patientVitalSign.createdBy.professions',
            'patientVitalSign.createdBy.specialties',
            'patientVitalSign.lastModifiedBy',
            'patientVitalSign.lastModifiedBy.professions',
            'patientVitalSign.lastModifiedBy.specialties',
            'doctor' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
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
            'visit.laboratory.testData.test',
            'visit.laboratory.testData.fields.field',
            'visit.laboratory.testData.fields.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visit.laboratory.testData.fields.createdBy.professions',
            'visit.laboratory.testData.fields.createdBy.specialties',
            'visit.laboratory.testData.fields.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'visit.laboratory.testData.fields.lastModifiedBy.professions',
            'visit.laboratory.testData.fields.lastModifiedBy.specialties',
        ])->find($consultationId);

        if (empty($consultation)) {
            abort(404);
        }

        ConsultationViewed::dispatch($consultation);
        $consultation = $consultation->toArray();

        return $consultation;
    }

    public function storeConsultation(
        string $visitId,
        array $consultDetails,
    ): string {
        $consultation = Consultation::create([
            'visit_id'                 => $visitId,
            'guardian_name'            => $consultDetails['guardian_name'],
            'guardian_contact_number'  => $consultDetails['guardian_contact_number'],
            'guardian_email'           => $consultDetails['guardian_email'],
            'guardian_relationship_id' => $consultDetails['guardian_relationship_id'],
            'doctor_id'                => $consultDetails['doctor_id'],
            'consult_reason'           => $consultDetails['consult_reason'] ?? '',
            'created_by'               => Auth::id(),
            'last_modified_by'         => Auth::id(),
        ]);

        // insert signs or symptoms
        $consultation->signsOrSymptoms()->sync($consultDetails['signs_or_symptoms_id']);

        ConsultationSoap::create([
            'consultation_id'  => $consultation->id,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        Diagnosis::create([
            'consultation_id'  => $consultation->id,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        return (string) $consultation->id;
    }

    public function getSmallPendingConsultationList(): array
    {
        return Visit::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'age', 'gender_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'patient.suffix' => function ($query) {
                $query->select('id', 'name');
            },
            'consultation',
            'consultation.doctor' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'consultation.doctor.professions',
            'consultation.signsOrSymptoms',
        ])->whereVisitStatusId(VisitStatusEnum::IN_CONSULTATION)->get()->toArray();
    }

    public function updateDetails(array $details): void
    {
        $id = $details['id'];

        unset($details['id']);

        $details['last_modified_by'] = Auth::id();

        $consultation = Consultation::find($id);
        $consultation->update($details);

        $this->updateSignsOrSymptoms($consultation, $details['signs_or_symptoms_id']);
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

        $diagnosis = Diagnosis::with('icd10Codes', 'consultation')->find($id);
        $diagnosis->update($diagnosisDetails);

        $this->updateIcd10Code($diagnosis, $icd10Ids);
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

    public function addOrUpdateVitalSigns(array $vitalSignDetails): void
    {
        if (empty($vitalSignDetails['patient_vital_sign_id'])) {
            $vitalSignDetails['created_by'] = Auth::id();
        }

        $vitalSignDetails['last_modified_by'] = Auth::id();

        PatientVitalSign::updateOrCreate(
            ['id' => $vitalSignDetails['patient_vital_sign_id']],
            $vitalSignDetails,
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

    public function updateSignsOrSymptoms(
        Consultation $consultation,
        array $signsOrSymptomIds,
    ): void {
        $audit = $consultation->signsOrSymptoms()->sync($signsOrSymptomIds);

        if (
            empty($audit['attached'])
            && empty($audit['detached'])
        ) {
            return;
        }

        SignsOrSymptomsSaved::dispatch(
            getRelatedAuditFields(
                SignsOrSymptomEnum::getDescriptionLists(),
                $audit,
            ),
            $consultation->id,
        );
    }

    public function updateIcd10Code(
        Diagnosis $diagnosis,
        array $ids,
    ): void {
        $diagnosis->loadMissing('consultation');
        $deletedRes = DiagnosisIcd10Code::with('icd10Code')->where('diagnosis_id', $diagnosis->id)->get()->toArray();
        $added = Icd10Code::whereIn('id', $ids);
        $deleted = array_column($deletedRes, 'icd10_code');

        $newDeleted = array_values(array_diff(array_column($deleted, 'code'), $added->pluck('code')->toArray()));
        $newAdded = array_values(array_diff($added->pluck('code')->toArray(), array_column($deleted, 'code')));

        $newDeletedIds = array_values(array_diff(array_column($deleted, 'id'), $added->pluck('id')->toArray()));
        $newAddedIds = array_values(array_diff($added->pluck('id')->toArray(), array_column($deleted, 'id')));

        if (
            empty($newDeletedIds)
            && empty($newAdded)
        ) {
            return;
        }

        $deleteIcd10 = [];
        foreach ($newDeletedIds as $key => $id) {
            $deleteIcd10[] = $deletedRes[$key]['id'];
        }

        DiagnosisIcd10Code::destroy($deleteIcd10);

        $insertIcd10 = [];
        foreach ($newAddedIds as $id) {
            $insertIcd10[] = [
                'diagnosis_id'  => $diagnosis->id,
                'icd10_code_id' => $id,
            ];
        }

        DiagnosisIcd10Code::fillAndInsert($insertIcd10);

        Icd10CodeSaved::dispatch(
            [
                'added'   => $newAdded,
                'deleted' => $newDeleted,
            ],
            $diagnosis->consultation->id,
        );
    }

    public function completeConsultation(string $consultationId)
    {
        $consultation = Consultation::with('visit', 'visit.billing', 'visit.laboratory', 'visit.patient', 'visit.consultation', 'visit.radiology')
            ->find($consultationId);
        $visit = $consultation->visit;

        if ($consultation->is_completed) {
            abort(404);
        }

        $consultation->update([
            'is_completed' => true,
        ]);

        $lab = app(VisitService::class)->getPendingData($visit->laboratory?->toArray() ?? []);
        $radio = app(VisitService::class)->getPendingData($visit->radiology?->toArray() ?? []);

        // check if has pending laboratory or radiology before moving to Billing
        $laboratoryId = null;
        $radiologyId = null;
        if ($lab['pending']) {
            $laboratoryId = $lab['id'];
        }
        if ($radio['pending']) {
            $radiologyId = $radio['id'];
        }

        if ($lab['pending'] || $radio['pending']) {
            // set to null to prevent adding consultation in billing if has pending
            $consultationId = null;
        } else {
            // set to consultationId to proceed with consultation fee
            $consultationId = $consultation->id;
        }

        // if laboratoryId and radiologyId is null then proceed to consultation fee
        app(BillingService::class)->storeBilling(
            visitId: $visit->id,
            laboratoryId: $laboratoryId,
            radiologyId: $radiologyId,
            consultationId: $consultationId,
        );

        $lab = app(VisitService::class)->getPendingData($consultation->visit->laboratory?->toArray() ?? []);
        $radio = app(VisitService::class)->getPendingData($consultation->radiology?->toArray() ?? []);

        // check if has pending laboratory or radiology before moving to Billing
        if (
            ! $lab['pending']
            && ! $radio['pending']
        ) {
            // create pharmacy record if theres no pending lab/radio and consultation is completed
            // pharmacy is optional so its not required for patient to go to pharmacy inorder
            // to complete the visit
            app(PharmacyService::class)->storePharmacy(
                visit: $visit,
                prescriptions: $visit->consultation->prescriptions->toArray(),
            );
        }

        // move patient to billing
        $visit->update([
            'visit_status_id' => VisitStatusEnum::IN_BILLING,
        ]);
    }
}
