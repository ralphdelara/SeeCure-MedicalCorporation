<?php

use App\Enums\LaboratoryFieldEnum;
use App\Enums\LaboratoryTestEnum;
use App\Models\LaboratoryField;
use App\Models\LaboratoryTest;
use App\Models\LaboratoryTestField;
use App\Services\LaboratoryFieldService;
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
        LaboratoryField::find(LaboratoryFieldEnum::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE)->update([
            'name' => LaboratoryFieldEnum::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE->description(),
        ]);

        LaboratoryField::create([
            'id' => LaboratoryFieldEnum::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE,
            'name' => LaboratoryFieldEnum::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE->description(),
            'unit' => LaboratoryFieldEnum::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE->unit(),
            'field_type' => LaboratoryFieldEnum::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE->fieldType(),
        ]);

        LaboratoryTestField::create([
            'laboratory_test_id' => LaboratoryTestEnum::FECALYSIS,
            'laboratory_field_id' => LaboratoryFieldEnum::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE,
        ]);

        app(LaboratoryFieldService::class)->orderTestFields();
    }
};
