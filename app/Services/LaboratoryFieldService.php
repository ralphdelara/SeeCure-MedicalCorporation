<?php

namespace App\Services;

use App\Enums\LaboratoryTestEnum;
use App\Enums\LaboratoryFieldEnum;
use App\Models\LaboratoryField;

class LaboratoryFieldService
{
    public function orderTestFields(): void
    {
        $orderCount = 1;
        $fieldIds = [];
        $testsEnums = [];
        $testsNames = [];

        /** @var LaboratoryTestEnum $test */
        foreach (LaboratoryTestEnum::cases() as $test) {
            $testsEnums[] = $test->testFields();
            $testsNames[] = $test->description();
            /** @var LaboratoryFieldEnum $field */
            foreach ($test->testFields() as $field) {
                if (in_array($field->value, $fieldIds)) {
                    continue;
                }

                $fieldIds[] = $field->value;

                LaboratoryField::where('id', $field->value)->update(['order' => $orderCount]);

                $orderCount++;
            }
        }
    }

    public function refreshNormalRanges(): void
    {
        /** @var LaboratoryFieldEnum $field */
        foreach (LaboratoryFieldEnum::cases() as $field) {
            if (is_null($field->normalRange())) {
                continue;
            }

            LaboratoryField::find($field->value)->update([
                'normal_range_both_min' => $field->normalRange()['both_min'],
                'normal_range_both_max' => $field->normalRange()['both_max'],
                'normal_range_female_min' => $field->normalRange()['female_min'],
                'normal_range_female_max' => $field->normalRange()['female_max'],
                'normal_range_male_min' => $field->normalRange()['male_min'],
                'normal_range_male_max' => $field->normalRange()['male_max'],
            ]);
        }
    }
}
