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

    public function tests(): array
    {
        return match ($this) {
            self::CLINICAL_CHEMISTRY => [
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
                LaboratoryTestEnum::OGTT_75G,
                LaboratoryTestEnum::SODIUM,
                LaboratoryTestEnum::POTASSIUM,
                LaboratoryTestEnum::CHLORIDE,
            ],
            self::CLINICAL_MICROSCOPY => [
                LaboratoryTestEnum::URINALYSIS,
                LaboratoryTestEnum::FECALYSIS,
                LaboratoryTestEnum::FECAL_OCCULT_BLOOD,
                LaboratoryTestEnum::PREGNANCY_URINE,
            ],
            self::IMMUNOLOGY_SEROLOGY => [
                LaboratoryTestEnum::PREGNANCY_SERUM,
                LaboratoryTestEnum::RPR_ANTI_TP,
                LaboratoryTestEnum::HBSAG,
                LaboratoryTestEnum::DENGUE_DUO,
                LaboratoryTestEnum::TYPHIDOT,
                LaboratoryTestEnum::CRP_QUANTITATIVE,
                LaboratoryTestEnum::H_PYLORI,
            ],
            self::CLINICAL_HEMATOLOGY => [
                LaboratoryTestEnum::COMPLETE_BLOOD_COUNT,
                LaboratoryTestEnum::CBC_W_PLATELET_COUNT,
                LaboratoryTestEnum::PLATELET_COUNT,
                LaboratoryTestEnum::ABO_TYPING,
                LaboratoryTestEnum::RH_TYPING,
                LaboratoryTestEnum::CLOTTING_TIME_BLEEDING_TIME,
            ],
        };
    }
}
