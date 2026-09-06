<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryTestEnum: int
{
    use EnumTraits;

    // CLINICAL CHEMISTRY (101 - 199)
    case FBS = 101;
    case RBS = 102;
    case BUN = 103;
    case CREATININE = 104;
    case URIC_ACID = 105;
    case TOTAL_CHOLESTEROL = 106;
    case TRIGLYCERIDES = 107;
    case HDL_CHOLESTEROL = 108;
    case LDL_CHOLESTEROL = 109;
    case SGPT_ALT = 110;
    case SGOT_AST = 111;
    case OGTT_75G = 112;
    case SODIUM = 113;
    case POTASSIUM = 114;
    case CHLORIDE = 115;
    case IONIZED_CALCIUM = 116;
    case IONIZED_MAGNESIUM = 117;

    // CLINICAL MICROSCOPY (201 - 299)
    case URINALYSIS = 201;
    case FECALYSIS = 202;
    case FECAL_OCCULT_BLOOD = 203;
    case PREGNANCY_URINE = 204;

    // IMMUNOLOGY SEROLOGY (301 - 399)
    case PREGNANCY_SERUM = 301;
    case RPR_ANTI_TP = 302;
    case HBSAG = 303;
    case DENGUE_DUO = 304;
    case TYPHIDOT = 305;
    case CRP_QUANTITATIVE = 306;
    case H_PYLORI = 307;

    // CLINICAL HEMATOLOGY (401 - 499)
    case COMPLETE_BLOOD_COUNT = 401;
    case CBC_W_PLATELET_COUNT = 402;
    case PLATELET_COUNT = 403;
    case ABO_TYPING = 404;
    case RH_TYPING = 405;
    case CLOTTING_TIME_BLEEDING_TIME = 406;

    /**
     * Get the clean display name for each laboratory test.
     */
    public function description(): string
    {
        return match ($this) {
            self::FBS               => 'Fasting Blood Sugar (FBS)',
            self::RBS               => 'Random Blood Sugar (RBS)',
            self::BUN               => 'Blood Urea Nitrogen (BUN)',
            self::CREATININE        => 'Creatinine',
            self::URIC_ACID         => 'Uric Acid',
            self::TOTAL_CHOLESTEROL => 'Total Cholesterol',
            self::TRIGLYCERIDES     => 'Triglycerides',
            self::HDL_CHOLESTEROL   => 'HDL Cholesterol',
            self::LDL_CHOLESTEROL   => 'LDL Cholesterol',
            self::SGPT_ALT          => 'SGPT / ALT',
            self::SGOT_AST          => 'SGOT / AST',
            self::OGTT_75G          => 'Oral Glucose Tolerance Test (75g)',
            self::SODIUM            => 'Sodium',
            self::POTASSIUM         => 'Potassium',
            self::CHLORIDE          => 'Chloride',
            self::IONIZED_CALCIUM   => 'Ionized Calcium',
            self::IONIZED_MAGNESIUM => 'Ionized Magnesium',

            self::URINALYSIS         => 'Urinalysis',
            self::FECALYSIS          => 'Fecalysis',
            self::FECAL_OCCULT_BLOOD => 'Fecal Occult Blood Test (FOBT)',
            self::PREGNANCY_URINE    => 'Pregnancy Test (Urine)',

            self::PREGNANCY_SERUM  => 'Pregnancy Test (Serum)',
            self::RPR_ANTI_TP      => 'RPR / Anti-TP',
            self::HBSAG            => 'HBsAg',
            self::DENGUE_DUO       => 'Dengue Duo (NS1, IgG, IgM)',
            self::TYPHIDOT         => 'Salmonella Typhi (IgG, Igm)',
            self::CRP_QUANTITATIVE => 'CRP (Quantitative)',
            self::H_PYLORI         => 'Helicobacter pylori Antibody Test',

            self::COMPLETE_BLOOD_COUNT        => 'Complete Blood Count (CBC)',
            self::CBC_W_PLATELET_COUNT        => 'CBC with Platelet Count',
            self::PLATELET_COUNT              => 'Platelet Count',
            self::ABO_TYPING                  => 'ABO Blood Typing',
            self::RH_TYPING                   => 'Rh Typing',
            self::CLOTTING_TIME_BLEEDING_TIME => 'Clotting Time & Bleeding Time (CT/BT)',
        };
    }

    public function prices(): float
    {
        return match ($this) {
            self::FBS               => 130,
            self::RBS               => 160,
            self::BUN               => 150,
            self::CREATININE        => 160,
            self::URIC_ACID         => 160,
            self::TOTAL_CHOLESTEROL => 160,
            self::TRIGLYCERIDES     => 160,
            self::HDL_CHOLESTEROL   => 160,
            self::LDL_CHOLESTEROL   => 160,
            self::SGPT_ALT          => 250,
            self::SGOT_AST          => 250,
            self::OGTT_75G          => 780,
            self::SODIUM            => 450,
            self::POTASSIUM         => 450,
            self::CHLORIDE          => 450,
            self::IONIZED_CALCIUM   => 850,
            self::IONIZED_MAGNESIUM => 850,

            self::URINALYSIS         => 120,
            self::FECALYSIS          => 150,
            self::FECAL_OCCULT_BLOOD => 500,
            self::PREGNANCY_URINE    => 180,

            self::PREGNANCY_SERUM  => 200,
            self::RPR_ANTI_TP      => 350,
            self::HBSAG            => 290,
            self::DENGUE_DUO       => 1620,
            self::TYPHIDOT         => 1000,
            self::CRP_QUANTITATIVE => 1058,
            self::H_PYLORI         => 1100,

            self::COMPLETE_BLOOD_COUNT        => 180,
            self::CBC_W_PLATELET_COUNT        => 280,
            self::PLATELET_COUNT              => 150,
            self::ABO_TYPING                  => 180,
            self::RH_TYPING                   => 150,
            self::CLOTTING_TIME_BLEEDING_TIME => 130,
        };
    }

    public function testFields(): array
    {
        return match ($this) {
            self::FBS => [
                LaboratoryTestFieldEnum::FBS,
            ],
            self::RBS => [
                LaboratoryTestFieldEnum::RBS,
            ],
            self::BUN => [
                LaboratoryTestFieldEnum::BUN,
            ],
            self::CREATININE => [
                LaboratoryTestFieldEnum::CREATININE,
            ],
            self::URIC_ACID => [
                LaboratoryTestFieldEnum::URIC_ACID,
            ],
            self::TOTAL_CHOLESTEROL => [
                LaboratoryTestFieldEnum::TOTAL_CHOLESTEROL,
            ],
            self::TRIGLYCERIDES => [
                LaboratoryTestFieldEnum::TRIGLYCERIDES,
            ],
            self::HDL_CHOLESTEROL => [
                LaboratoryTestFieldEnum::HDL_CHOLESTEROL,
            ],
            self::LDL_CHOLESTEROL => [
                LaboratoryTestFieldEnum::LDL_CHOLESTEROL,
            ],
            self::SGPT_ALT => [
                LaboratoryTestFieldEnum::SGPT_ALT,
            ],
            self::SGOT_AST => [
                LaboratoryTestFieldEnum::SGOT_AST,
            ],
            self::OGTT_75G => [
                LaboratoryTestFieldEnum::FBS,
                LaboratoryTestFieldEnum::FIRST_HOUR,
                LaboratoryTestFieldEnum::SECOND_HOUR,
            ],
            self::SODIUM => [
                LaboratoryTestFieldEnum::SODIUM,
            ],
            self::POTASSIUM => [
                LaboratoryTestFieldEnum::POTASSIUM,
            ],
            self::CHLORIDE => [
                LaboratoryTestFieldEnum::CHLORIDE,
            ],
            self::IONIZED_CALCIUM => [
                LaboratoryTestFieldEnum::IONIZED_CALCIUM,
            ],
            self::IONIZED_MAGNESIUM => [
                LaboratoryTestFieldEnum::IONIZED_MAGNESIUM,
            ],
            self::URINALYSIS => [
                LaboratoryTestFieldEnum::URI_PHYSICAL_PROPERTIES,
                LaboratoryTestFieldEnum::URI_COLOR,
                LaboratoryTestFieldEnum::URI_TRANSPARENCY,
                LaboratoryTestFieldEnum::URI_REACTION,
                LaboratoryTestFieldEnum::URI_SPECIFIC_GRAVITY,
                LaboratoryTestFieldEnum::URI_CHEMICAL_PROPERTIES,
                LaboratoryTestFieldEnum::URI_SUGAR,
                LaboratoryTestFieldEnum::URI_PROTEIN,
                LaboratoryTestFieldEnum::URI_CHEMICAL_PROPERTIES_OTHERS,
                LaboratoryTestFieldEnum::URI_MICROSCOPIC_FINDINGS,
                LaboratoryTestFieldEnum::URI_PUS_CELL,
                LaboratoryTestFieldEnum::URI_RED_BLOOD_CELL,
                LaboratoryTestFieldEnum::URI_CRYSTAL,
                LaboratoryTestFieldEnum::URI_CAST,
                LaboratoryTestFieldEnum::URI_AMOURPHOUS_URATE_PHOSPATE,
                LaboratoryTestFieldEnum::URI_SQUAMOUS_EPITHELIAL_CELL,
                LaboratoryTestFieldEnum::URI_ROUND_EPITHELIAL_CELL,
                LaboratoryTestFieldEnum::URI_MUCUS_THREAD,
                LaboratoryTestFieldEnum::URI_BACTERIA,
                LaboratoryTestFieldEnum::URI_MICROSCOPIC_FINDINGS_OTHERS,
            ],
            self::FECALYSIS => [
                LaboratoryTestFieldEnum::FECA_PHYSICAL,
                LaboratoryTestFieldEnum::FECA_COLOR,
                LaboratoryTestFieldEnum::FECA_CONSISTENCY,
                LaboratoryTestFieldEnum::FECA_BLOOD,
                LaboratoryTestFieldEnum::FECA_MUCUS,
                LaboratoryTestFieldEnum::FECA_CHEMICAL,
                LaboratoryTestFieldEnum::FECA_OCCULT_BLOOD,
                LaboratoryTestFieldEnum::FECA_CHEMICAL_OTHERS,
                LaboratoryTestFieldEnum::FECA_MICROSCOPIC,
                LaboratoryTestFieldEnum::FECA_ASCARIS,
                LaboratoryTestFieldEnum::FECA_HOOKWORM,
                LaboratoryTestFieldEnum::FECA_TRICHURIS,
                LaboratoryTestFieldEnum::FECA_STRONGYLOIDES,
                LaboratoryTestFieldEnum::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST,
                LaboratoryTestFieldEnum::FECA_TROPHOZOITE,
                LaboratoryTestFieldEnum::FECA_ENTAMOEBA_COLI_CYST,
                LaboratoryTestFieldEnum::FECA_BLASTOCYSTIS_SPP,
                LaboratoryTestFieldEnum::FECA_MICROSCOPIC_OTHERS,
                LaboratoryTestFieldEnum::FECA_CELLULAR_ELEMENTS,
                LaboratoryTestFieldEnum::FECA_PUS_CELL,
                LaboratoryTestFieldEnum::FECA_RED_BLOOD_CELL,
                LaboratoryTestFieldEnum::FECA_YEAST_CELL,
                LaboratoryTestFieldEnum::FECA_FAT_GLOBULES,
                LaboratoryTestFieldEnum::FECA_BACTERIA,
                LaboratoryTestFieldEnum::FECA_CELLULAR_OTHERS,
            ],
            self::FECAL_OCCULT_BLOOD => [
                LaboratoryTestFieldEnum::FECA_OCCULT_BLOOD,
            ],
            self::PREGNANCY_URINE    => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],

            self::PREGNANCY_SERUM => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],
            self::RPR_ANTI_TP     => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],
            self::HBSAG           => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],
            self::DENGUE_DUO      => [
                LaboratoryTestFieldEnum::DENGUE_NS1_ANTIGEN,
                LaboratoryTestFieldEnum::DENGUE_IGM_ANTIBODY,
                LaboratoryTestFieldEnum::DENGUE_IGG_ANTIBODY,
            ],
            self::TYPHIDOT         => [
                LaboratoryTestFieldEnum::SALMONELLA_TYPHI_IGG_ANTIBODY,
                LaboratoryTestFieldEnum::SALMONELLA_TYPHI_IGG_ANTIBODY,
            ],
            self::CRP_QUANTITATIVE => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],
            self::H_PYLORI         => [
                LaboratoryTestFieldEnum::RESULT_TEXT,
            ],

            self::COMPLETE_BLOOD_COUNT        => [
                LaboratoryTestFieldEnum::HEMA_BLOOD_STUDIES,
                LaboratoryTestFieldEnum::HEMA_HEMOGLOBIN,
                LaboratoryTestFieldEnum::HEMA_HEMATOCRIT,
                LaboratoryTestFieldEnum::HEMA_RBC_COUNT,
                LaboratoryTestFieldEnum::HEMA_WBC_COUNT,
                LaboratoryTestFieldEnum::HEMA_NUCLEATED_RBCS,
                LaboratoryTestFieldEnum::HEMA_DIFFERENTIAL_COUNT,
                LaboratoryTestFieldEnum::HEMA_NEUTROPHILS,
                LaboratoryTestFieldEnum::HEMA_SEGMENTERS,
                LaboratoryTestFieldEnum::HEMA_STAB,
                LaboratoryTestFieldEnum::HEMA_EOSINOPHILS,
                LaboratoryTestFieldEnum::HEMA_BASOPHILS,
                LaboratoryTestFieldEnum::HEMA_LYMPHOCYTES,
                LaboratoryTestFieldEnum::HEMA_MONOCYTES,
            ],
            self::CBC_W_PLATELET_COUNT        => [
                LaboratoryTestFieldEnum::HEMA_BLOOD_STUDIES,
                LaboratoryTestFieldEnum::HEMA_HEMOGLOBIN,
                LaboratoryTestFieldEnum::HEMA_HEMATOCRIT,
                LaboratoryTestFieldEnum::HEMA_RBC_COUNT,
                LaboratoryTestFieldEnum::HEMA_WBC_COUNT,
                LaboratoryTestFieldEnum::HEMA_PLATELET_COUNT,
                LaboratoryTestFieldEnum::HEMA_NUCLEATED_RBCS,
                LaboratoryTestFieldEnum::HEMA_DIFFERENTIAL_COUNT,
                LaboratoryTestFieldEnum::HEMA_NEUTROPHILS,
                LaboratoryTestFieldEnum::HEMA_SEGMENTERS,
                LaboratoryTestFieldEnum::HEMA_STAB,
                LaboratoryTestFieldEnum::HEMA_EOSINOPHILS,
                LaboratoryTestFieldEnum::HEMA_BASOPHILS,
                LaboratoryTestFieldEnum::HEMA_LYMPHOCYTES,
                LaboratoryTestFieldEnum::HEMA_MONOCYTES,
            ],
            self::PLATELET_COUNT              => [
                LaboratoryTestFieldEnum::HEMA_PLATELET_COUNT,
            ],
            self::ABO_TYPING                  => [
                LaboratoryTestFieldEnum::HEMA_BLOOD_TYPE,
            ],
            self::RH_TYPING                   => [
                LaboratoryTestFieldEnum::HEMA_BLOOD_TYPE,
            ],
            self::CLOTTING_TIME_BLEEDING_TIME => [
                LaboratoryTestFieldEnum::HEMA_BLEEDING_TIME_MIN,
                LaboratoryTestFieldEnum::HEMA_BLEEDING_TIME_SEC,
                LaboratoryTestFieldEnum::HEMA_CLOTTING_TIME_MIN,
                LaboratoryTestFieldEnum::HEMA_CLOTTING_TIME_SEC,
            ],
        };
    }
}
