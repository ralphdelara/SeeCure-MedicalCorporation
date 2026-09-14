<?php

namespace App\Services;

use App\Enums\BillingTypeEnum;
use App\Enums\SignsOrSymptomEnum;
use App\Enums\VisitStatusEnum;
use App\Events\ConsultationViewed;
use App\Events\Icd10CodeSaved;
use App\Events\SignsOrSymptomsSaved;
use App\Models\BillingDetail;
use App\Models\Consultation;
use App\Models\ConsultationAudit;
use App\Models\ConsultationDiagnosis;
use App\Models\ConsultationDiagnosisIcd10Code;
use App\Models\ConsultationSoap;
use App\Models\Icd10Code;
use App\Models\Laboratory;
use App\Models\Patient;
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
            'signsOrSymptoms',
            'doctor.professions',
            'doctor.specialties',
            'visit',
        ]);

        if (! empty($keyword)) {
            $consultationList = $consultationList->whereHas('patient', function ($query) use ($keyword) {
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
                $query->where('visit_status_id', VisitStatusEnum::IN_CONSULTATION);
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
            'laboratory',
            'laboratory.testData.test',
            'laboratory.testData.fields.field',
            'laboratory.testData.fields.createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'laboratory.testData.fields.createdBy.professions',
            'laboratory.testData.fields.createdBy.specialties',
            'laboratory.testData.fields.lastModifiedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'laboratory.testData.fields.lastModifiedBy.professions',
            'laboratory.testData.fields.lastModifiedBy.specialties',
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
            'doctor_id'                => $consultDetails['doctor_id'],
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

        ConsultationDiagnosis::create([
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

        $consultationDiagnosis = ConsultationDiagnosis::with('icd10Codes', 'consultation')->find($id);
        $consultationDiagnosis->update($diagnosisDetails);

        $this->updateIcd10Code($consultationDiagnosis, $icd10Ids);
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
        ConsultationDiagnosis $diagnosis,
        array $ids,
    ): void {
        $diagnosis->loadMissing('consultation');
        $deletedRes = ConsultationDiagnosisIcd10Code::with('icd10Code')->where('consultation_diagnosis_id', $diagnosis->id)->get()->toArray();
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

        ConsultationDiagnosisIcd10Code::destroy($deleteIcd10);

        $insertIcd10 = [];
        foreach ($newAddedIds as $id) {
            $insertIcd10[] = [
                'consultation_diagnosis_id' => $diagnosis->id,
                'icd10_code_id'             => $id,
            ];
        }

        ConsultationDiagnosisIcd10Code::fillAndInsert($insertIcd10);

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

        $hasLabPending = app(VisitService::class)->hasPending($visit->laboratory?->toArray() ?? []);
        $hasRadioPending = app(VisitService::class)->hasPending($visit->radiology?->toArray() ?? []);

        // check if has pending laboratory or radiology before moving to Billing
        $laboratoryId = null;
        $radiologyId = null;
        if ($hasLabPending) {
            $laboratoryId = Laboratory::where('is_completed', false)->get()->first()->id;
        }
        if ($hasRadioPending) {
            $radiologyId = Radiology::where('is_completed', false)->get()->first()->id;
        }

        if ($hasLabPending || $hasRadioPending) {
            // set to null to prevent adding consultation in billing if has pending
            $consultationId = null;
        } else {
            // set to consultationId to proceed with consultation fee
            $consultationId = $consultation->id;
        }

        // if laboratoryId and radiologyId is null then proceed to consultation fee
        $billingId = app(BillingService::class)->storeBilling(
            $visit->patient->id,
            $visit->id,
            $consultationId,
            $laboratoryId,
            $radiologyId,
        );


        app(CashierService::class)->storeCashier(
            $visit->patient->id,
            $visit->id,
            $billingId,
        );

        // set visit status to billing
        Visit::find($consultation->visit->id)->update([
            'visit_status_id' => VisitStatusEnum::IN_BILLING,
        ]);
    }
}
