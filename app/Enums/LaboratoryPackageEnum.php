<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryPackageEnum: int
{
    use EnumTraits;

    case BLOOD_CHEMISTRY_PACKAGE = 1;
    case LIPID_PROFILE = 2;
    case CUSTOM = 3;

    public function description(): string
    {
        return match ($this) {
            self::BLOOD_CHEMISTRY_PACKAGE => 'Blood Chemistry Package',
            self::LIPID_PROFILE           => 'Lipid Profile',
            self::CUSTOM                  => 'Custom',
        };
    }

    public function tests(): array
    {
        return match ($this) {
            self::BLOOD_CHEMISTRY_PACKAGE => [
                LaboratoryTestEnum::FBS,
                LaboratoryTestEnum::RBS,
                LaboratoryTestEnum::BUN,
                LaboratoryTestEnum::CREATININE,
                LaboratoryTestEnum::URIC_ACID,
                LaboratoryTestEnum::TOTAL_CHOLESTEROL,
                LaboratoryTestEnum::TRIGLYCERIDES,
                LaboratoryTestEnum::HDL_CHOLESTEROL,
                LaboratoryTestEnum::LDL_CHOLESTEROL,
                LaboratoryTestEnum::SGPT_ALT,
                LaboratoryTestEnum::SGOT_AST,
            ],
            self::LIPID_PROFILE => [
                LaboratoryTestEnum::TOTAL_CHOLESTEROL,
                LaboratoryTestEnum::TRIGLYCERIDES,
                LaboratoryTestEnum::HDL_CHOLESTEROL,
                LaboratoryTestEnum::LDL_CHOLESTEROL,
            ],
            self::CUSTOM => [],
        };
    }

    public function price(): float
    {
        return match ($this) {
            self::BLOOD_CHEMISTRY_PACKAGE => 1720,
            self::LIPID_PROFILE           => 620,
            self::CUSTOM                  => 0,
        };
    }
}
