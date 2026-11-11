<?php

use App\Enums\LaboratoryFieldEnum;
use App\Models\LaboratoryField;
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
        LaboratoryField::find(LaboratoryFieldEnum::HBA1C)->update([
            'unit' => LaboratoryFieldEnum::HBA1C->unit(),
            'normal_range_both_min' => LaboratoryFieldEnum::HBA1C->normalRange()['both_min'],
            'normal_range_both_max' => LaboratoryFieldEnum::HBA1C->normalRange()['both_max'],
        ]);
    }
};
