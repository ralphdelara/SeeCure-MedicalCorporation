<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryTestSubTypeEnum: int
{
    use EnumTraits;

    case FASTING_BLOOD_SUGAR = 1;
    case RANDOM_BLOOD_SUGAR = 2;
    case BLOOD_UREA_NITROGEN = 3;
    case CREATININE = 4;
    case URIC_ACID = 5;
    case LIPID_PROFILE = 6;
    case SGPT_ALT = 7;
    case SGOT_AST = 8;
    case ORAL_GLUCOSE_TOLERANCE_TEST = 9;
    case SODIUM = 10;
    case POTASSIUM = 11;
    case CHLORIDE = 12;

    case FECAL_OCCULT_BLOOD_TEST = 13;
    case FECALYSIS = 14;
    case URINALYSIS = 15;
    case PREGNANCY_TEST_URINE = 16;

    case ASOT_HPYLON = 17;
    case HBSAG = 18;
    case DENGUE_DUO = 19;
    case TYPHIDOT = 20;
    case CRP = 21;
    case PREGNANCY_TEST_SERUM = 22;
    case RPR_ANTI_TP = 23;

    case BLOOD_CHEMISTRY_PACKAGE = 24;

    case CBC_W_PLATELET_COUNT = 25;
    case ABO_TYPING = 26;
    case COMPLETE_BLOOD_COUNT = 27;
    case CLOTTING_TIME_BLEEDING_TIME = 28;
    case RH_TYPING = 29;
    case PLATELET_COUNT = 30;

    case HDL = 31;
    case TOTAL_CHOLESTEROL = 32;
    case ECG = 33;
    case LDL = 34;
    case TRIGLYCERIDES = 35;

    public function description(): string
    {
        return match ($this) {
            self::FASTING_BLOOD_SUGAR         => 'Fasting Blood Sugar (FBS)',
            self::RANDOM_BLOOD_SUGAR          => 'Random Blood Sugar (RBS)',
            self::BLOOD_UREA_NITROGEN         => 'Blood Urea Nitrogen (BUN)',
            self::CREATININE                  => 'Creatinine',
            self::URIC_ACID                   => 'Uric Acid',
            self::LIPID_PROFILE               => 'Lipid Profile',
            self::SGPT_ALT                    => 'SGPT / ALT',
            self::SGOT_AST                    => 'SGOT / AST',
            self::ORAL_GLUCOSE_TOLERANCE_TEST => 'Oral Glucose Tolerance Test (OGTT)',
            self::SODIUM                      => 'Sodium (Na+)',
            self::POTASSIUM                   => 'Potassium (K+)',
            self::CHLORIDE                    => 'Chloride (Cl-)',

            self::FECAL_OCCULT_BLOOD_TEST => 'Fecal Occult Blood Test (FOBT)',
            self::FECALYSIS               => 'Fecalysis',
            self::URINALYSIS              => 'Urinalysis',
            self::PREGNANCY_TEST_URINE    => 'Pregnancy Test (Urine)',

            self::ASOT_HPYLON          => 'ASOT / H. Pylori',
            self::HBSAG                => 'Hepatitis B Surface Antigen (HBsAg)',
            self::DENGUE_DUO           => 'Dengue Duo',
            self::TYPHIDOT             => 'Typhidot',
            self::CRP                  => 'C-Reactive Protein (CRP)',
            self::PREGNANCY_TEST_SERUM => 'Pregnancy Test (Serum)',
            self::RPR_ANTI_TP          => 'RPR / Anti-TP (Syphilis)',

            self::BLOOD_CHEMISTRY_PACKAGE => 'Blood Chemistry Package',

            self::CBC_W_PLATELET_COUNT        => 'CBC with Platelet Count',
            self::ABO_TYPING                  => 'ABO Blood Typing',
            self::COMPLETE_BLOOD_COUNT        => 'Complete Blood Count (CBC)',
            self::CLOTTING_TIME_BLEEDING_TIME => 'Clotting Time & Bleeding Time (CT/BT)',
            self::RH_TYPING                   => 'Rh Blood Typing',
            self::PLATELET_COUNT              => 'Platelet Count',

            self::HDL               => 'High-Density Lipoprotein (HDL)',
            self::TOTAL_CHOLESTEROL => 'Total Cholesterol',
            self::ECG               => 'Electrocardiogram (ECG / EKG)',
            self::LDL               => 'Low-Density Lipoprotein (LDL)',
            self::TRIGLYCERIDES     => 'Triglycerides',
        };
    }

    public function price(): float
    {
        return match ($this) {
            self::FASTING_BLOOD_SUGAR         => 130,
            self::RANDOM_BLOOD_SUGAR          => 160,
            self::BLOOD_UREA_NITROGEN         => 150,
            self::CREATININE                  => 160,
            self::URIC_ACID                   => 160,
            self::LIPID_PROFILE               => 620,
            self::SGPT_ALT                    => 250,
            self::SGOT_AST                    => 250,
            self::ORAL_GLUCOSE_TOLERANCE_TEST => 780,
            self::SODIUM                      => 450,
            self::POTASSIUM                   => 450,
            self::CHLORIDE                    => 450,

            self::FECAL_OCCULT_BLOOD_TEST => 500,
            self::FECALYSIS               => 150,
            self::URINALYSIS              => 120,
            self::PREGNANCY_TEST_URINE    => 180,

            self::ASOT_HPYLON          => 1100,
            self::HBSAG                => 290,
            self::DENGUE_DUO           => 1620,
            self::TYPHIDOT             => 1000,
            self::CRP                  => 1058,
            self::PREGNANCY_TEST_SERUM => 200,
            self::RPR_ANTI_TP          => 350,

            self::BLOOD_CHEMISTRY_PACKAGE => 1720,

            self::CBC_W_PLATELET_COUNT        => 280,
            self::ABO_TYPING                  => 180,
            self::COMPLETE_BLOOD_COUNT        => 180,
            self::CLOTTING_TIME_BLEEDING_TIME => 130,
            self::RH_TYPING                   => 150,
            self::PLATELET_COUNT              => 150,

            self::HDL               => 160,
            self::TOTAL_CHOLESTEROL => 160,
            self::ECG               => 350,
            self::LDL               => 160,
            self::TRIGLYCERIDES     => 160,
        };
    }

    public function typeId(): float
    {
        return match ($this) {
            self::FASTING_BLOOD_SUGAR         => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::RANDOM_BLOOD_SUGAR          => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::BLOOD_UREA_NITROGEN         => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::CREATININE                  => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::URIC_ACID                   => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::LIPID_PROFILE               => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::SGPT_ALT                    => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::SGOT_AST                    => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::ORAL_GLUCOSE_TOLERANCE_TEST => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::SODIUM                      => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::POTASSIUM                   => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,
            self::CHLORIDE                    => LaboratoryTestTypeEnum::CLINICAL_CHEMISTRY->value,

            self::FECAL_OCCULT_BLOOD_TEST => LaboratoryTestTypeEnum::CLINICAL_MICROSCOPY->value,
            self::FECALYSIS               => LaboratoryTestTypeEnum::CLINICAL_MICROSCOPY->value,
            self::URINALYSIS              => LaboratoryTestTypeEnum::CLINICAL_MICROSCOPY->value,
            self::PREGNANCY_TEST_URINE    => LaboratoryTestTypeEnum::CLINICAL_MICROSCOPY->value,

            self::ASOT_HPYLON          => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::HBSAG                => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::DENGUE_DUO           => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::TYPHIDOT             => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::CRP                  => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::PREGNANCY_TEST_SERUM => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,
            self::RPR_ANTI_TP          => LaboratoryTestTypeEnum::IMMUNOLOGY_SEROLOGY->value,

            self::BLOOD_CHEMISTRY_PACKAGE => LaboratoryTestTypeEnum::BLOOD_CHEMISTRY_PACKAGE->value,

            self::CBC_W_PLATELET_COUNT        => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,
            self::ABO_TYPING                  => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,
            self::COMPLETE_BLOOD_COUNT        => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,
            self::CLOTTING_TIME_BLEEDING_TIME => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,
            self::RH_TYPING                   => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,
            self::PLATELET_COUNT              => LaboratoryTestTypeEnum::CLINICAL_HEMATOLOGY->value,

            self::HDL               => LaboratoryTestTypeEnum::OTHERS->value,
            self::TOTAL_CHOLESTEROL => LaboratoryTestTypeEnum::OTHERS->value,
            self::ECG               => LaboratoryTestTypeEnum::OTHERS->value,
            self::LDL               => LaboratoryTestTypeEnum::OTHERS->value,
            self::TRIGLYCERIDES     => LaboratoryTestTypeEnum::OTHERS->value,
        };
    }

    public function fields(): array
    {
        return match ($this) {
            self::FASTING_BLOOD_SUGAR => [
                [
                    'field_name'              => self::FASTING_BLOOD_SUGAR->description(),
                    'normal_value_male_min'   => null,
                    'normal_value_male_max'   => null,
                    'normal_value_female_min' => null,
                    'normal_value_female_max' => null,
                    'normal_value_both_min'   => 3.9,
                    'normal_value_both_max'   => 6.4,
                    'type'                    => 'numeric',
                ],
            ],
            self::RANDOM_BLOOD_SUGAR => [
                [
                    'field_name'              => self::RANDOM_BLOOD_SUGAR->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 7.8,
                'normal_value_both_max'   => 11.1,
                'type'                    => 'numeric',
                ],
            ],
            self::BLOOD_UREA_NITROGEN => [
                [
                    'field_name'              => self::BLOOD_UREA_NITROGEN->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 2.8,
                'normal_value_both_max'   => 7.2,
                'type'                    => 'numeric',
            ],
            ],
            self::CREATININE => [
                [
                    'field_name'              => self::CREATININE->description(),
                'normal_value_male_min'   => 62,
                'normal_value_male_max'   => 115,
                'normal_value_female_min' => 53,
                'normal_value_female_max' => 97,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => 'numeric',
            ],
            ],
            self::URIC_ACID => [
                [
                    'field_name'              => self::URIC_ACID->description(),
                'normal_value_male_min'   => 208,
                'normal_value_male_max'   => 428,
                'normal_value_female_min' => 155,
                'normal_value_female_max' => 357,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => 'numeric',
            ],
            ],
            self::LIPID_PROFILE => [
                [
                    'field_name'              => self::LIPID_PROFILE->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            ],
            self::SGPT_ALT => [
                [
                    'field_name'              => self::SGPT_ALT->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => 0,
                'normal_value_female_max' => 45,
                'normal_value_both_min'   => 0,
                'normal_value_both_max'   => 34,
                'type'                    => 'numeric',
            ],
            ],
            self::SGOT_AST => [
                [
                    'field_name'              => self::SGOT_AST->description(),
                'normal_value_male_min'   => 0,
                'normal_value_male_max'   => 35,
                'normal_value_female_min' => 0,
                'normal_value_female_max' => 31,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => 'numeric',
            ],
            ],
            self::ORAL_GLUCOSE_TOLERANCE_TEST => [
                [
                    'field_name'              => self::ORAL_GLUCOSE_TOLERANCE_TEST->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 6.1,
                'normal_value_both_max'   => null,
                'type'                    => 'numeric',
            ],
            ],
            self::SODIUM => [
                [
                    'field_name'              => self::SODIUM->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 135,
                'normal_value_both_max'   => 148,
                'type'                    => 'numeric',
            ],
            ],
            self::POTASSIUM => [
                [
                    'field_name'              => self::POTASSIUM->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 3.5,
                'normal_value_both_max'   => 5.3,
                'type'                    => 'numeric',
            ],
            ],
            self::CHLORIDE => [
                [
                    'field_name'              => self::CHLORIDE->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 98,
                'normal_value_both_max'   => 107,
                'type'                    => 'numeric',
            ],
            ],

            self::FECAL_OCCULT_BLOOD_TEST => [
                [
                    'field_name'              => self::FECAL_OCCULT_BLOOD_TEST->description(),
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            ],
            self::FECALYSIS => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::URINALYSIS => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::PREGNANCY_TEST_URINE => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],

            self::ASOT_HPYLON => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::HBSAG => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::DENGUE_DUO => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::TYPHIDOT => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::CRP => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::PREGNANCY_TEST_SERUM => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::RPR_ANTI_TP => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],

            self::BLOOD_CHEMISTRY_PACKAGE => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],

            self::CBC_W_PLATELET_COUNT => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::ABO_TYPING => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::COMPLETE_BLOOD_COUNT => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::CLOTTING_TIME_BLEEDING_TIME => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::RH_TYPING => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::PLATELET_COUNT => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::HDL => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 0.9,
                'normal_value_both_max'   => 0,
                'type'                    => 'numeric',
            ],
            self::TOTAL_CHOLESTEROL => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 0,
                'normal_value_both_max'   => 5.2,
                'type'                    => 'numeric',
            ],
            self::ECG => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => null,
                'normal_value_both_max'   => null,
                'type'                    => '',
            ],
            self::LDL => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 0,
                'normal_value_both_max'   => 3.4,
                'type'                    => 'numeric',
            ],
            self::TRIGLYCERIDES => [
                'normal_value_male_min'   => null,
                'normal_value_male_max'   => null,
                'normal_value_female_min' => null,
                'normal_value_female_max' => null,
                'normal_value_both_min'   => 0,
                'normal_value_both_max'   => 2.3,
                'type'                    => 'numeric',
            ],
        };
    }
}
