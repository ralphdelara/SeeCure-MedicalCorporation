<?php

namespace App\Services;

use App\Enums\AuditTypeEnum;
use App\Enums\VisitStatusEnum;
use App\Events\LaboratoryViewed;
use App\Models\Consultation;
use App\Models\Laboratory;
use App\Models\LaboratoryAudit;
use App\Models\LaboratoryPackage;
use App\Models\LaboratoryPackageTest;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestData;
use App\Models\LaboratoryTestField;
use App\Models\LaboratoryTestFieldData;
use App\Models\Patient;
use App\Models\Visit;
use Arr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LaboratoryService
{
    public function getLaboratoryList(
        ?string $keyword,
        ?string $status,
        string $path,
    ): array {
        $laboratoryList = Laboratory::with([
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'patient_suffix_id', 'gender_id');
            },
            'patient.suffix.name',
            'patient.gender.name',
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
            $laboratoryList = $laboratoryList->whereHas('patient', function ($query) use ($keyword) {
                /** @var Builder|Patient $query */
                $query->whereBlind('last_name_index', 'last_name_index', strtolower($keyword))
                    ->orWhereBlind('first_name_index', 'first_name_index', strtolower($keyword))
                    ->orWhereBlind('middle_name_index', 'middle_name_index', strtolower($keyword));
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
        ?string $visitId,
        ?string $patientId,
        ?string $consultationId,
        array $laboratoryDetails,
    ): string {
        $laboratory = Laboratory::create([
            'visit_id'         => $visitId,
            'patient_id'       => $patientId,
            'consultation_id'  => $consultationId,
            'created_by'       => Auth::id(),
            'last_modified_by' => Auth::id(),
        ]);

        $testIds = $laboratoryDetails['other_test_ids'];

        $packageId = $laboratoryDetails['laboratory_package_id'];
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

        $fields = LaboratoryTestField::whereIn('laboratory_test_id', $testIds)->get();

        $insertTestFields = [];

        foreach ($fields as $field) {
            $insertTestFields[] = [
                'laboratory_id'            => $laboratory->id,
                'laboratory_test_data_id'  => $testDataIds[$field->laboratory_test_id],
                'laboratory_test_field_id' => $field->id,
                'created_by'               => Auth::id(),
                'last_modified_by'         => Auth::id(),
            ];
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
            'patient' => function ($query) {
                $query->select('id', 'first_name', 'middle_name', 'last_name', 'age', 'gender_id', 'patient_suffix_id');
            },
            'patient.gender' => function ($query) {
                $query->select('id', 'name');
            },
            'testData',
            'testData.type',
            'testData.test',
            'testData.fields' => function ($query) {
                $query->orderBy('order_no');
            },
            'testData.fields.field',
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

        if (app(VisitService::class)->hasPending($laboratory->visit->radiology?->toArray() ?? [])) {
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
                'type'  => $type,
                'tests' => array_values($tests), // array_values resets key to 0
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

        $this->updateTest($id, $details);

        $this->updateTestFields($id, $details);
    }

    public function updateTest(string $id, array $details): void
    {
        $tests = [];
        $updateFields = [];

        $allTests = LaboratoryTest::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $prevTests = LaboratoryTestData::select('laboratory_test_id', 'remarks')->get()->pluck('value', 'laboratory_test_id')->toArray();

        foreach ($details as $key => $value) {
            if (
                ! str_contains($key, '_remarks')
            ) {
                continue;
            }

            $testDataArr = explode('_', str_replace('_remarks', '', str_replace('test_', '', $key)));

            // used double equal for both null and empty string
            if ($prevTests[$testDataArr[0]] == $value) {
                continue;
            }

            $updateFields[] = [
                'field' => $allTests[$testDataArr[0]],
                'from'  => null,
                'to'    => $value,
            ];

            $tests[] = [
                'id'                    => $testDataArr[1],
                'laboratory_id'         => $id,
                'laboratory_package_id' => $testDataArr[2] !== 'null' ? (int) $testDataArr[2] : null,
                'laboratory_type_id'    => (int) $testDataArr[3],
                'laboratory_test_id'    => (int) $testDataArr[0],
                'created_by'            => Auth::id(),
                'remarks'               => Crypt::encryptString($value),
                'last_modified_by'      => Auth::id(),
                'updated_at'            => now(),
            ];
        }

        if (empty($updateFields)) {
            return;
        }

        LaboratoryTestData::upsert(
            $tests,
            uniqueBy: ['id'],
            update: ['remarks', 'last_modified_by', 'updated_at'],
        );

        $this->logAudit(
            $id,
            AuditTypeEnum::UPDATE,
            'Laboratory Test has been updated.',
            $updateFields,
        );
    }

    public function updateTestFields(string $id, array $details): void
    {
        $fields = [];
        $updateFields = [];

        $allTestFields = LaboratoryTestField::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        $prevTestFieldData = LaboratoryTestFieldData::select('laboratory_test_field_id', 'value')->get()->pluck('value', 'laboratory_test_field_id')->toArray();

        foreach ($details as $key => $value) {
            if (! str_contains($key, 'field_')) {
                continue;
            }

            $ids = explode('_', str_replace('field_', '', $key));

            // used double equal for both null and empty string
            if ($prevTestFieldData[$ids[2]] == $value) {
                continue;
            }

            $updateFields[] = [
                'field' => $allTestFields[$ids[2]],
                'from'  => $prevTestFieldData[$ids[2]],
                'to'    => $value,
            ];

            $fields[] = [
                'laboratory_id'            => $id,
                'id'                       => $ids[1],
                'laboratory_test_data_id'  => $ids[0],
                'laboratory_test_field_id' => (int) $ids[2],
                'value'                    => Crypt::encryptString($value),
                'created_by'               => Auth::id(),
                'last_modified_by'         => Auth::id(),
                'updated_at'               => now(),
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

        if (app(VisitService::class)->hasPending($laboratory->visit->radiology?->toArray() ?? [])) {
            // move to radiology if has pending radiology
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_RADIOLOGY,
            ]);
        } elseif ($laboratory->visit->has_consultation) {
            // move to consultation
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::IN_CONSULTATION,
            ]);

            // set is_completed to false to activate Consultation Data
            // because only one consultation data is allowed per visit
            Consultation::find($laboratory->visit->consultation->id)->update([
                'is_completed' => false,
            ]);
        } else {
            Visit::find($laboratory->visit->id)->update([
                'visit_status_id' => VisitStatusEnum::COMPLETED,
            ]);
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
