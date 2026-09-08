<?php

use App\Enums\LaboratoryTestEnum;
use App\Models\LaboratoryTestField;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    /**
     * Determine if the operation is being processed asynchronously.
     */
    protected bool $async = false;

    /**
     * The queue that the job will be dispatched to.
     */
    protected string $queue = 'default';

    /**
     * A tag name, that this operation can be filtered by.
     */
    protected ?string $tag = null;

    /**
     * Process the operation.
     */
    public function process(): void
    {
        $array = [];

        foreach (LaboratoryTestEnum::cases() as $testCase) {
            foreach ($testCase->testFields() as $fieldCase) {
                $bothMin = null;
                $bothMax = null;
                $maleMin = null;
                $maleMax = null;
                $femaleMin = null;
                $femaleMax = null;

                if ($fieldCase->normalRange()) {
                    $bothMin = $fieldCase->normalRange()['both_min'];
                    $bothMax = $fieldCase->normalRange()['both_max'];
                    $maleMin = $fieldCase->normalRange()['male_min'];
                    $maleMax = $fieldCase->normalRange()['male_max'];
                    $femaleMin = $fieldCase->normalRange()['female_min'];
                    $femaleMax = $fieldCase->normalRange()['female_max'];
                }

                $array[] = [
                    'laboratory_test_id'      => $testCase->value,
                    'name'                    => $fieldCase->description(),
                    'unit'                    => $fieldCase->unit(),
                    'field_type'              => $fieldCase->fieldType(),
                    'normal_range_both_min'   => $bothMin,
                    'normal_range_both_max'   => $bothMax,
                    'normal_range_male_min'   => $maleMin,
                    'normal_range_male_max'   => $maleMax,
                    'normal_range_female_min' => $femaleMin,
                    'normal_range_female_max' => $femaleMax,
                ];
            }
        }

        LaboratoryTestField::fillAndInsert($array);
    }
};
