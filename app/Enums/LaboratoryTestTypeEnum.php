<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryTestTypeEnum: int
{
    use EnumTraits;

    case CLINICAL_CHEMISTRY = 1;
    case CLINICAL_MICROSCOPY = 2;
    case IMMUNOLOGY_SEROLOGY = 3;
    case BLOOD_CHEMISTRY_PACKAGE = 4;
    case CLINICAL_HEMATOLOGY = 5;
    case OTHERS = 6;

    public function description(): string
    {
        return match ($this) {
            self::CLINICAL_CHEMISTRY      => 'Clinical Chemistry',
            self::CLINICAL_MICROSCOPY     => 'Clinical Microscopy',
            self::IMMUNOLOGY_SEROLOGY     => 'Immunology/Serology',
            self::BLOOD_CHEMISTRY_PACKAGE => 'Blood Chemistry Package',
            self::CLINICAL_HEMATOLOGY     => 'Clinical Hematology',
            self::OTHERS                  => 'Others',
        };
    }
}
