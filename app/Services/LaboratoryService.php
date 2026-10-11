<?php

namespace App\Services;

use App\Enums\AuditTypeEnum;
use App\Enums\VisitStatusEnum;
use App\Events\LaboratoryViewed;
use App\Models\Consultation;
use App\Models\Laboratory;
use App\Models\LaboratoryAudit;
use App\Models\LaboratoryField;
use App\Models\LaboratoryPackage;
use App\Models\LaboratoryPackageTest;
use App\Models\LaboratoryRemark;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestField;
use App\Models\LaboratoryTestFieldData;
use App\Models\LaboratoryType;
use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use Arr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class LaboratoryService
{
    public function getLaboratoryList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $laboratoryList = Laboratory::with([
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'gender_id');
            },
            'visit.patient.suffix',
            'visit.patient.gender',
            'visit.priorityTypes',
            'testData',
            'testData.package',
            'testData.type',
            'testData.test',
            'testData.fields',
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
            $laboratoryList = $laboratoryList->whereHas('visit.patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */

                // Group the OR conditions inside a sub-query callback
                $query->where(function ($subQuery) use ($keyword) {
                    $searchKeyword = strtolower($keyword);

                    $subQuery->whereBlind('last_name_index', 'last_name_index', $searchKeyword)
                        ->orWhereBlind('first_name_index', 'first_name_index', $searchKeyword)
                        ->orWhereBlind('middle_name_index', 'middle_name_index', $searchKeyword);
                });
            });
        }

        if ($status === 'completed') {
            $laboratoryList = $laboratoryList->where('is_completed', true);
        } else {
            $laboratoryList = $laboratoryList->whereHas('visit', function ($query) {
                $query->where('visit_status_id', VisitStatusEnum::IN_LABORATORY)
                    ->where('is_completed', false);
            });
        }

        $laboratoryList = $laboratoryList
            ->paginate(50)
            ->withPath('/'.$path)->withQueryString();

        $tableData = $laboratoryList->collect()->toArray();
        $pageData = Arr::except($laboratoryList->toArray(), ['data']);
        $links = app(PageService::class)->limitLinks($laboratoryList, 5);
        $pageData['links'] = $links;

        return compact(
            'tableData',
            'pageData',
        );
    }

    public function storeLaboratory(
        string $visitId,
        array $laboratoryDetails,
    ): string {
        $laboratory = Laboratory::create([
            'visit_id'         => $visitId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $testIds = $laboratoryDetails['other_test_ids'];

        $packageId = $laboratoryDetails['laboratory_package_id'];

        $laboratory->packageData()->sync([$laboratoryDetails['laboratory_package_id']]);

        $packageTestIds = [];

        if (! empty($packageId)) {
            $packageTestIds = LaboratoryPackageTest::select('laboratory_test_id')
                ->where('laboratory_package_id', $packageId)->pluck('laboratory_test_id')->toArray();
        }

        $testIds = array_merge($testIds, $packageTestIds);

        $tests = LaboratoryTest::with('package', 'type', 'fields')->whereIn('id', $testIds)->get()->toArray();
        $insertTests = [];
        $auditFields = [];

        foreach ($tests as $test) {
            $auditFields[] = $test['name'];

            $insertTests[] = [
                'laboratory_id'         => $laboratory->id,
                'laboratory_package_id' => $test['package'] ? $test['package']['id'] : null,
                'laboratory_type_id'    => $test['type']['id'],
                'laboratory_test_id'    => $test['id'],
                'created_by'            => Auth::id(),
                'last_modified_by'      => Auth::id(),
            ];
        }

        $testDataIds = $laboratory->testData()->createMany($insertTests)
            ->pluck('id', 'laboratory_test_id');

        $fields = LaboratoryTestField::whereIn('laboratory_test_id', $testIds)
            ->orderBy('laboratory_field_id')->get();

        $insertTestFields = [];

        $testFieldIds = [];

        foreach ($fields as $field) {
            if (in_array($field->laboratory_field_id, $testFieldIds)) {
                continue;
            }

            $insertTestFields[] = [
                'laboratory_id'           => $laboratory->id,
                'laboratory_test_data_id' => $testDataIds[$field->laboratory_test_id],
                'laboratory_field_id'     => $field->laboratory_field_id,
                'created_by'              => Auth::id(),
                'last_modified_by'        => Auth::id(),
            ];
            $testFieldIds[] = $field->laboratory_field_id;
        }

        $auditData = [
            'title'  => 'Laboratory Tests has been added.',
            'fields' => [[
                'field' => 'Tests',
                'from'  => null,
                'to'    => implode(', ', $auditFields),
            ],
            ]];

        LaboratoryAudit::create([
            'laboratory_id' => $laboratory->id,
            'audit_type_id' => AuditTypeEnum::ADD,
            'data'          => json_encode($auditData),
            'created_by'    => Auth::id(),
        ]);

        LaboratoryTestFieldData::fillAndInsert($insertTestFields);

        return $laboratory->id;
    }

    public function getLaboratoryFormOptions(): array
    {
        $laboratoryPackageOptions = LaboratoryPackage::all();

        return compact(
            'laboratoryPackageOptions',
        );
    }

    public function getTests(string $packageId): array
    {
        $selectedPackage = LaboratoryPackage::with('tests')->find($packageId)->toArray();

        $excludedTestIds = array_column($selectedPackage['tests'], 'id');

        $otherTests = LaboratoryTest::with('type')->whereNotIn('id', $excludedTestIds)->get()->toArray();

        $arrayTests = [];

        // this adds the available tests per type
        foreach ($otherTests as $test) {
            $arrayTests[$test['type']['name']][] = $test;
        }

        $otherTests = [];

        // this parses the array data to make it easily readable in front end
        foreach ($arrayTests as $key => $arrayValue) {
            $otherTests[] = [
                'type'  => $key,
                'tests' => $arrayValue,
            ];
        }

        return compact('selectedPackage', 'otherTests');
    }

    public function getLaboratoryDetails(string $id): ?array
    {
        abortIfInvalidUuid($id);

        $laboratory = Laboratory::with([
            'visit.patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'visit.patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'remarks',
            'testData',
            'testData.type',
            'testData.test',
            'testData.fields' => function ($query) {
                $query->orderBy('id');
            },
            'testData.fields.field',
            'performedBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'performedBy.professions',
            'performedBy.specialties',
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
        ])->find($id);

        if (empty($laboratory)) {
            abort(404);
        }

        $moveToText = 'Completed';
        $radio = app(VisitService::class)->getPendingData($laboratory->visit->radiology?->toArray() ?? []);

        if ($radio['pending']) {
            $moveToText = 'Radiology';
        } elseif ($laboratory->visit->has_consultation) {
            $moveToText = 'Consultation';
        }

        LaboratoryViewed::dispatch($laboratory);

        $laboratory = $laboratory->toArray();

        $testFields = [];
        $testTypes = array_column(array_column($laboratory['test_data'], 'type'), 'name', 'id');

        foreach ($testTypes as $key => $type) {
            $tests = array_filter($laboratory['test_data'], function ($item) use ($key) {
                return $item['laboratory_type_id'] === $key;
            });

            $testFields[] = [
                'type_id' => $key,
                'type'    => $type,
                'tests'   => array_values($tests), // array_values resets key to 0
            ];
        }

        $laboratory['test_data'] = $testFields;
        $laboratory['moveToText'] = $moveToText;

        return $laboratory;
    }

    public function getAuditLog(string $laboratoryId): array
    {
        return LaboratoryAudit::with([
            'createdBy' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name');
            },
            'createdBy.professions',
            'createdBy.specialties',
            'auditType',
        ])
            ->select('audit_type_id', 'data', 'created_by', 'created_at')
            ->where('laboratory_id', $laboratoryId)
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }

    public function updateDetails(array $details): void
    {
        $id = $details['id'];

        unset($details['id']);

        $details['last_modified_by'] = Auth::id();

        $this->updateLabFields($id, $details);

        $this->updateTestFields($id, $details);

        $this->updateTestRemarks($id, $details);
    }

    public function updateLabFields(string $id, array $details): void
    {

        $fields = [];
        $updateFields = [];
        $lab = Laboratory::with(
            'performedBy',
            'performedBy.professions',
            'performedBy.specialties',
        )->find($id);

        if ($lab->performed_by !== $details['performed_by']) {
            $fields['performed_by'] = $details['performed_by'];
            $newPerformedBy = User::with('professions', 'specialties')->find($details['performed_by']);

            $updateFields[] = [
                'field' => 'Performed By',
                'from'  => $lab->performedBy?->full_name,
                'to'    => $newPerformedBy?->full_name,
            ];
        }

        $datePerformed = $details['date_performed'];
        if (! empty($datePerformed)) {
            $datePerformed = Carbon::parse($details['date_performed'])?->format('M d, Y');
        }
        if ($lab->date_performed?->format('M d, Y') !== $datePerformed) {
            $updateFields[] = [
                'field' => 'Date Performed',
                'from'  => $lab->date_performed?->format('M d, Y'),
                'to'    => $datePerformed,
            ];
        }

        if (! empty($updateFields)) {
            Laboratory::find($id)->update([
                'performed_by'   => $details['performed_by'],
                'date_performed' => $details['date_performed'],
            ]);

            $this->logAudit(
                $id,
                AuditTypeEnum::UPDATE,
                'Laboratory has been updated.',
                $updateFields,
            );
        }
    }

    public function updateTestFields(string $id, array $details): void
    {
        $fields = [];
        $updateFields = [];

        $allFields = LaboratoryField::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $prevTestFieldData = LaboratoryTestFieldData::select('laboratory_field_id', 'value')
            ->where('laboratory_id', $id)
            ->get()->pluck('value', 'laboratory_field_id')->toArray();

        foreach ($details as $key => $value) {
            if (
                ! str_contains($key, 'field_')
                || str_contains($key, '_remarks')
            ) {
                continue;
            }

            $ids = explode('_', str_replace('field_', '', $key));

            // used double equal for both null and empty string
            if ($prevTestFieldData[$ids[2]] == $value) {
                continue;
            }

            $updateFields[] = [
                'field' => $allFields[$ids[2]],
                'from'  => $prevTestFieldData[$ids[2]],
                'to'    => $value,
            ];

            $fields[] = [
                'laboratory_id'           => $id,
                'id'                      => $ids[1],
                'laboratory_test_data_id' => $ids[0],
                'laboratory_field_id'     => (int) $ids[2],
                'value'                   => Crypt::encryptString($value),
                'created_by'              => Auth::id(),
                'last_modified_by'        => Auth::id(),
                'updated_at'              => now(),
            ];
        }

        if (empty($updateFields)) {
            return;
        }

        LaboratoryTestFieldData::upsert(
            $fields,
            uniqueBy: ['id'],
            update: ['value', 'last_modified_by', 'updated_at'],
        );

        $this->logAudit(
            $id,
            AuditTypeEnum::UPDATE,
            'Laboratory Test Field has been updated.',
            $updateFields,
        );
    }

    public function updateTestRemarks(string $id, array $details)
    {
        $fields = [];
        $updateFields = [];
        $labRemarksCount = LaboratoryRemark::where('laboratory_id')->count();
        $allTest = LaboratoryTest::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $allTypeFields = LaboratoryType::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $prevTestRemarksData = LaboratoryRemark::select('laboratory_test_id', 'remarks')
            ->where('laboratory_id', $id)
            ->get()->pluck('remarks', 'laboratory_test_id')->toArray();
        $prevTypeRemarksData = LaboratoryRemark::select('laboratory_type_id', 'remarks')
            ->where('laboratory_id', $id)
            ->get()->pluck('remarks', 'laboratory_type_id')->toArray();
        $prevTestRemarksIds = LaboratoryRemark::select('laboratory_test_id', 'id')
            ->where('laboratory_id', $id)
            ->get()->pluck('id', 'laboratory_test_id')->toArray();
        $prevTypeRemarksIds = LaboratoryRemark::select('laboratory_type_id', 'id')
            ->where('laboratory_id', $id)
            ->get()->pluck('id', 'laboratory_type_id')->toArray();

        foreach ($details as $key => $value) {
            if (
                ! str_contains($key, '_remarks')
            ) {
                continue;
            }

            $ids = explode('_', str_replace('type_', '', str_replace('_test', '', str_replace('_remarks', '', $key))));
            $typeId = $ids[0];
            $testId = $ids[1];

            $remarksId = match (true) {
                $testId === '0' && isset($prevTypeRemarksIds[$typeId]) => $prevTypeRemarksIds[$typeId],
                $testId !== '0' && isset($prevTestRemarksIds[$testId]) => $prevTestRemarksIds[$testId],
                default                                                => $labRemarksCount > 0 ? null : Str::uuid7(), // set to null to trigger error preventing duplicate data
            };

            $fieldsTmp = [
                'id'                 => $remarksId,
                'laboratory_id'      => $id,
                'laboratory_type_id' => $typeId,
                'laboratory_test_id' => $testId === '0' ? null : $testId,
                'remarks'            => Crypt::encryptString($value),
                'created_by'         => Auth::id(),
                'last_modified_by'   => Auth::id(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ];

            $fields[] = $fieldsTmp;

            $from = match (true) {
                $testId === '0' && array_key_exists($typeId, $prevTypeRemarksData) => $prevTypeRemarksData[$typeId],
                $testId !== '0' && array_key_exists($testId, $prevTestRemarksData) => $prevTestRemarksData[$testId],
                default                                                            => null,
            };

            if ($from == $value) {
                continue;
            }

            $updateFields[] = [
                'field' => $testId === '0' ? $allTypeFields[$typeId] : $allTest[$testId],
                'from'  => $from,
                'to'    => $value,
            ];
        }

        if (empty($updateFields)) {
            return;
        }

        LaboratoryRemark::upsert(
            $fields,
            uniqueBy: ['id'],
            update: ['remarks', 'last_modified_by', 'updated_at'],
        );

        $this->logAudit(
            $id,
            AuditTypeEnum::UPDATE,
            'Laboratory Remarks has been updated.',
            $updateFields,
        );
    }

    public function completeLaboratory(string $id)
    {
        $laboratory = Laboratory::with('visit', 'visit.consultation', 'visit.radiology')
            ->find($id);

        if ($laboratory->is_completed) {
            abort(404);
        }

        $laboratory->update([
            'is_completed' => true,
        ]);

        $radio = app(VisitService::class)->getPendingData($laboratory->visit->radiology?->toArray() ?? []);

        if ($radio['pending']) {
            // move to radiology if has pending radiology
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_RADIOLOGY,
            ]);
        } elseif ($laboratory->visit->has_consultation) {
            // move to consultation if theres no pending radiology
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_CONSULTATION,
            ]);

            // set is_completed to false to activate Consultation Data
            // because only one consultation data is allowed per visit
            Consultation::find($laboratory->visit->consultation->id)->update([
                'is_completed' => false,
            ]);
        } else {
            // complete the patient visit if theres nothing else
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::COMPLETED,
            ]);

            // delete patient info if walk in
            if ($laboratory->visit->is_walk_in) {
                app(PatientService::class)->deletePatient($laboratory->visit->patient_id ?? Patient::walkInPatient()->id);
            }
        }
    }

    public function getSmallPendingLaboratoryList(): array
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
            'laboratory',
            'laboratory.testData',
            'laboratory.testData.fields',
        ])->whereVisitStatusId(VisitStatusEnum::IN_LABORATORY)->get()->toArray();
    }

    public function logAudit(
        string $id,
        AuditTypeEnum $auditTypeEnum,
        string $title = '',
        array $auditFields = [],
    ): void {
        $auditData = [
            'title'  => $title,
            'fields' => $auditFields,
        ];

        LaboratoryAudit::create([
            'laboratory_id' => $id,
            'audit_type_id' => $auditTypeEnum,
            'data'          => json_encode($auditData),
            'created_by'    => Auth::id(),
        ]);
    }
}
