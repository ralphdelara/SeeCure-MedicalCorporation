<?php

namespace App\Services;

use App\Enums\LaboratoryTestEnum;
use App\Enums\LaboratoryFieldEnum;
use App\Models\LaboratoryField;

class LaboratoryFieldService
{
    public function orderTestFields()
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
        //dd($testsNames, $testsEnums, $fieldIds);
    }
}
