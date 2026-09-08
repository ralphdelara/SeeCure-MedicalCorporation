<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryTypeEnum: int
{
    use EnumTraits;

    case CLINICAL_CHEMISTRY = 1;
    case CLINICAL_MICROSCOPY = 2;
    case IMMUNOLOGY_SEROLOGY = 3;
    case CLINICAL_HEMATOLOGY = 4;

    public function description(): string
    {
        return match ($this) {
            self::CLINICAL_CHEMISTRY  => 'Clinical Chemistry',
            self::CLINICAL_MICROSCOPY => 'Clinical Microscopy',
            self::IMMUNOLOGY_SEROLOGY => 'Immunology/Serology',
            self::CLINICAL_HEMATOLOGY => 'Clinical Hematology',
        };
    }
}
