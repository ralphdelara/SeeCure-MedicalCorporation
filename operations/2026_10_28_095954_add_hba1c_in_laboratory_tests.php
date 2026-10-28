<?php

use App\Enums\LaboratoryFieldEnum;
use App\Enums\LaboratoryTestEnum;
use App\Models\LaboratoryField;
use App\Models\LaboratoryTest;
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
        LaboratoryTest::fillAndInsert([
            'name'               => LaboratoryTestEnum::HBA1C->description(),
            'price'              => LaboratoryTestEnum::HBA1C->price(),
            'laboratory_type_id' => LaboratoryTestEnum::HBA1C->type(),
        ]);

        LaboratoryField::fillAndInsert([
            'name'                    => LaboratoryFieldEnum::HBA1C->description(),
            'unit'                    => LaboratoryFieldEnum::HBA1C->unit(),
            'field_type'              => LaboratoryFieldEnum::HBA1C->fieldType(),
            'normal_range_both_min'   => null,
            'normal_range_both_max'   => LaboratoryFieldEnum::HBA1C->normalRange()['both_max'],
            'normal_range_male_min'   => null,
            'normal_range_male_max'   => null,
            'normal_range_female_min' => null,
            'normal_range_female_max' => null,
        ]);

        LaboratoryTestField::fillAndInsert([
            'laboratory_test_id'  => LaboratoryTestEnum::HBA1C->value,
            'laboratory_field_id' => LaboratoryFieldEnum::HBA1C->value,
        ]);
    }
};
