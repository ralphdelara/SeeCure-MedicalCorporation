<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryFieldEnum: int
{
    use EnumTraits;
    // Clinical Chemistry
    case FBS = 1;
    case RBS = 2;
    case BUN = 3;
    case CREATININE = 4;
    case URIC_ACID = 5;
    case SGPT_ALT = 6;
    case SGOT_AST = 7;
    case LIPID_PROFILE = 8;
    case TOTAL_CHOLESTEROL = 9;
    case TRIGLYCERIDES = 10;
    case HDL_CHOLESTEROL = 11;
    case LDL_CHOLESTEROL = 12;
    case SODIUM = 13;
    case POTASSIUM = 14;
    case CHLORIDE = 15;
    case IONIZED_CALCIUM = 16;
    case IONIZED_MAGNESIUM = 17;
    case FIRST_HOUR = 18;
    case SECOND_HOUR = 19;
    case HBA1C = 97;

    // Hematology
    case HEMA_BLOOD_STUDIES = 20;
    case HEMA_HEMOGLOBIN = 21;
    case HEMA_HEMATOCRIT = 22;
    case HEMA_RBC_COUNT = 23;
    case HEMA_WBC_COUNT = 24;
    case HEMA_PLATELET_COUNT = 25;
    case HEMA_NUCLEATED_RBCS = 26;

    case HEMA_BLOOD_TYPE = 27;
    case HEMA_BLEEDING_TIME_MIN = 28;
    case HEMA_BLEEDING_TIME_SEC = 29;
    case HEMA_CLOTTING_TIME_MIN = 30;
    case HEMA_CLOTTING_TIME_SEC = 31;
    case HEMA_ESR_WESTERGREN = 32;

    case HEMA_DIFFERENTIAL_COUNT = 33;
    case HEMA_NEUTROPHILS = 34;
    case HEMA_SEGMENTERS = 35;
    case HEMA_STAB = 36;
    case HEMA_EOSINOPHILS = 37;
    case HEMA_BASOPHILS = 38;
    case HEMA_LYMPHOCYTES = 39;
    case HEMA_MONOCYTES = 40;

    // Urinalysis
    case URI_PHYSICAL_PROPERTIES = 41;
    case URI_COLOR = 42;
    case URI_TRANSPARENCY = 43;
    case URI_REACTION = 44;
    case URI_SPECIFIC_GRAVITY = 45;
    case URI_CHEMICAL_PROPERTIES = 46;
    case URI_SUGAR = 47;
    case URI_PROTEIN = 48;
    case URI_CHEMICAL_PROPERTIES_OTHERS = 49;
    case URI_MICROSCOPIC_FINDINGS = 50;
    case URI_PUS_CELL = 51;
    case URI_RED_BLOOD_CELL = 52;
    case URI_CRYSTAL = 53;
    case URI_CAST = 54;
    case URI_AMOURPHOUS_URATE_PHOSPATE = 55;
    case URI_SQUAMOUS_EPITHELIAL_CELL = 56;
    case URI_ROUND_EPITHELIAL_CELL = 57;
    case URI_MUCUS_THREAD = 58;
    case URI_BACTERIA = 59;
    case URI_MICROSCOPIC_FINDINGS_OTHERS = 60;

    // Fecalysis
    case FECA_PHYSICAL = 61;
    case FECA_COLOR = 62;
    case FECA_CONSISTENCY = 63;
    case FECA_BLOOD = 64;
    case FECA_MUCUS = 65;
    case FECA_CHEMICAL = 66;
    case FECA_OCCULT_BLOOD = 67;
    case FECA_CHEMICAL_OTHERS = 68;
    case FECA_MICROSCOPIC = 69;
    case FECA_ASCARIS = 70;
    case FECA_HOOKWORM = 71;
    case FECA_TRICHURIS = 72;
    case FECA_STRONGYLOIDES = 73;
    case FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST = 74;
    case FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE = 75;
    case FECA_ENTAMOEBA_COLI_CYST = 76;
    case FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE = 98;
    case FECA_BLASTOCYSTIS_SPP = 77;
    case FECA_MICROSCOPIC_OTHERS = 78;
    case FECA_CELLULAR_ELEMENTS = 79;
    case FECA_PUS_CELL = 80;
    case FECA_RED_BLOOD_CELL = 81;
    case FECA_YEAST_CELL = 82;
    case FECA_FAT_GLOBULES = 83;
    case FECA_BACTERIA = 84;
    case FECA_CELLULAR_OTHERS = 85;

    // Miscellaneous
    case DENGUE_NS1_ANTIGEN = 86;
    case DENGUE_IGM_ANTIBODY = 87;
    case DENGUE_IGG_ANTIBODY = 88;

    case SALMONELLA_TYPHI_IGM_ANTIBODY = 89;
    case SALMONELLA_TYPHI_IGG_ANTIBODY = 90;

    case PREGNANCY_URINE_RESULT_TEXT = 91;
    case PREGNANCY_SERUM_RESULT_TEXT = 92;
    case RPR_ANTI_TP_RESULT_TEXT = 93;
    case HBSAG_RESULT_TEXT = 94;
    case CRP_QUANTITATIVE_RESULT_TEXT = 95;
    case H_PYLORI_RESULT_TEXT = 96;

    public function description(): string
    {
        return match ($this) {
            // Clinical Chemistry
            self::FBS               => 'Fasting Blood Sugar (FBS)',
            self::RBS               => 'Random Blood Sugar (RBS)',
            self::BUN               => 'Blood Urea Nitrogen (BUN)',
            self::CREATININE        => 'Creatinine',
            self::URIC_ACID         => 'Uric Acid',
            self::SGPT_ALT          => 'SGPT/ALT',
            self::SGOT_AST          => 'SGOT/AST',
            self::LIPID_PROFILE     => 'LIPID PROFILE',
            self::TOTAL_CHOLESTEROL => 'Total Cholesterol',
            self::TRIGLYCERIDES     => 'Triglycerides',
            self::HDL_CHOLESTEROL   => 'HDL Cholesterol',
            self::LDL_CHOLESTEROL   => 'LDL Cholesterol',
            self::SODIUM            => 'Sodium',
            self::POTASSIUM         => 'Potassium',
            self::CHLORIDE          => 'Chloride',
            self::IONIZED_CALCIUM   => 'Ionized Calcium',
            self::IONIZED_MAGNESIUM => 'Ionized Magnesium',
            self::FIRST_HOUR        => 'First Hour',
            self::SECOND_HOUR       => 'Second Hour',
            self::HBA1C             => 'HBA1C',

            // Hematology
            self::HEMA_BLOOD_STUDIES      => 'BLOOD STUDIES',
            self::HEMA_HEMOGLOBIN         => 'Hemoglobin',
            self::HEMA_HEMATOCRIT         => 'Hematocrit',
            self::HEMA_RBC_COUNT          => 'RBC Count',
            self::HEMA_WBC_COUNT          => 'WBC Count',
            self::HEMA_PLATELET_COUNT     => 'Platelet Count',
            self::HEMA_NUCLEATED_RBCS     => 'Nucleated RBCs (nRBC)',
            self::HEMA_BLOOD_TYPE         => 'Blood Type',
            self::HEMA_BLEEDING_TIME_MIN  => 'Bleeding Time (Minutes)',
            self::HEMA_BLEEDING_TIME_SEC  => 'Bleeding Time (Seconds)',
            self::HEMA_CLOTTING_TIME_MIN  => 'Clotting Time (Minutes)',
            self::HEMA_CLOTTING_TIME_SEC  => 'Clotting Time (Seconds)',
            self::HEMA_ESR_WESTERGREN     => 'ESR (Westergren)',
            self::HEMA_DIFFERENTIAL_COUNT => 'DIFFERENTIAL COUNT',
            self::HEMA_NEUTROPHILS        => 'Neutrophils',
            self::HEMA_SEGMENTERS         => 'Segmenters',
            self::HEMA_STAB               => 'Stab / Band Neutrophils',
            self::HEMA_EOSINOPHILS        => 'Eosinophils',
            self::HEMA_BASOPHILS          => 'Basophils',
            self::HEMA_LYMPHOCYTES        => 'Lymphocytes',
            self::HEMA_MONOCYTES          => 'Monocytes',

            // Urinalysis
            self::URI_PHYSICAL_PROPERTIES         => 'PHYSICAL PROPERTIES',
            self::URI_COLOR                       => 'Color',
            self::URI_TRANSPARENCY                => 'Transparency',
            self::URI_REACTION                    => 'Reaction',
            self::URI_SPECIFIC_GRAVITY            => 'Specific Gravity',
            self::URI_CHEMICAL_PROPERTIES         => 'CHEMICAL PROPERTIES',
            self::URI_SUGAR                       => 'Sugar',
            self::URI_PROTEIN                     => 'Protein',
            self::URI_CHEMICAL_PROPERTIES_OTHERS  => 'Others',
            self::URI_MICROSCOPIC_FINDINGS        => 'MICROSCOPIC FINDINGS',
            self::URI_PUS_CELL                    => 'Pus Cell',
            self::URI_RED_BLOOD_CELL              => 'Red Blood Cell',
            self::URI_CRYSTAL                     => 'Crystal',
            self::URI_CAST                        => 'Cast',
            self::URI_AMOURPHOUS_URATE_PHOSPATE   => 'Amourphous Urate/Phosphate',
            self::URI_SQUAMOUS_EPITHELIAL_CELL    => 'Squamous Epithelial Cells',
            self::URI_ROUND_EPITHELIAL_CELL       => 'Round Epithelial Cells',
            self::URI_MUCUS_THREAD                => 'Mucus Threads',
            self::URI_BACTERIA                    => 'Bacteria',
            self::URI_MICROSCOPIC_FINDINGS_OTHERS => 'Others',

            // Fecalysis
            self::FECA_PHYSICAL                          => 'PHYSICAL',
            self::FECA_COLOR                             => 'Color',
            self::FECA_CONSISTENCY                       => 'Consistency',
            self::FECA_BLOOD                             => 'Blood',
            self::FECA_MUCUS                             => 'Mucus',
            self::FECA_CHEMICAL                          => 'CHEMICAL',
            self::FECA_OCCULT_BLOOD                      => 'Occult Blood',
            self::FECA_CHEMICAL_OTHERS                   => 'Others',
            self::FECA_MICROSCOPIC                       => 'MICROSCOPIC',
            self::FECA_ASCARIS                           => 'Ascaris',
            self::FECA_HOOKWORM                          => 'Hookworm',
            self::FECA_TRICHURIS                         => 'Trichuris',
            self::FECA_STRONGYLOIDES                     => 'Strongyloides',
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST => 'Entamoeba histolytica/dispar (Cyst)',
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE => 'Trophozoite (histolytica)',
            self::FECA_ENTAMOEBA_COLI_CYST               => 'Entamoeba coli (Cyst)',
            self::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE => 'Trophozoite (coli)',
            self::FECA_BLASTOCYSTIS_SPP                  => 'Blastocystis spp.',
            self::FECA_MICROSCOPIC_OTHERS                => 'Others',
            self::FECA_CELLULAR_ELEMENTS                 => 'CELLULAR ELEMENTS',
            self::FECA_PUS_CELL                          => 'Pus Cells',
            self::FECA_RED_BLOOD_CELL                    => 'Red Blood Cells',
            self::FECA_YEAST_CELL                        => 'Yeast Cells',
            self::FECA_FAT_GLOBULES                      => 'Fat Globules',
            self::FECA_BACTERIA                          => 'Bacteria',
            self::FECA_CELLULAR_OTHERS                   => 'Others',

            // Miscellaneous
            self::DENGUE_NS1_ANTIGEN            => 'Dengue NS1 Antigen',
            self::DENGUE_IGM_ANTIBODY           => 'Dengue IgM Antibody',
            self::DENGUE_IGG_ANTIBODY           => 'Dengue IgG Antibody',
            self::SALMONELLA_TYPHI_IGM_ANTIBODY => 'Salmonella typhi IgM Antibody',
            self::SALMONELLA_TYPHI_IGG_ANTIBODY => 'Salmonella typhi IgG Antibody',
            self::PREGNANCY_URINE_RESULT_TEXT   => 'Pregnancy (Urine)',
            self::PREGNANCY_SERUM_RESULT_TEXT   => 'Pregnancy (Serum)',
            self::RPR_ANTI_TP_RESULT_TEXT       => 'RPR / Anti-TP',
            self::HBSAG_RESULT_TEXT             => 'HBsAg',
            self::CRP_QUANTITATIVE_RESULT_TEXT  => 'CRP (Quantitative)',
            self::H_PYLORI_RESULT_TEXT          => 'Helicobacter pylori Antibody Test',
        };
    }

    public function fieldType(): string
    {
        return match ($this) {
            // Clinical Chemistry
            self::FBS               => 'numeric',
            self::RBS               => 'numeric',
            self::BUN               => 'numeric',
            self::CREATININE        => 'numeric',
            self::URIC_ACID         => 'numeric',
            self::SGPT_ALT          => 'numeric',
            self::SGOT_AST          => 'numeric',
            self::LIPID_PROFILE     => 'label',
            self::TOTAL_CHOLESTEROL => 'numeric',
            self::TRIGLYCERIDES     => 'numeric',
            self::HDL_CHOLESTEROL   => 'numeric',
            self::LDL_CHOLESTEROL   => 'numeric',
            self::SODIUM            => 'numeric',
            self::POTASSIUM         => 'numeric',
            self::CHLORIDE          => 'numeric',
            self::IONIZED_CALCIUM   => 'numeric',
            self::IONIZED_MAGNESIUM => 'numeric',
            self::FIRST_HOUR        => 'numeric',
            self::SECOND_HOUR       => 'numeric',
            self::HBA1C             => 'numeric',

            // Hematology
            self::HEMA_BLOOD_STUDIES      => 'label',
            self::HEMA_HEMOGLOBIN         => 'numeric',
            self::HEMA_HEMATOCRIT         => 'numeric',
            self::HEMA_RBC_COUNT          => 'numeric',
            self::HEMA_WBC_COUNT          => 'numeric',
            self::HEMA_PLATELET_COUNT     => 'numeric',
            self::HEMA_NUCLEATED_RBCS     => 'numeric',
            self::HEMA_BLOOD_TYPE         => 'text',
            self::HEMA_BLEEDING_TIME_MIN  => 'numeric',
            self::HEMA_BLEEDING_TIME_SEC  => 'numeric',
            self::HEMA_CLOTTING_TIME_MIN  => 'numeric',
            self::HEMA_CLOTTING_TIME_SEC  => 'numeric',
            self::HEMA_ESR_WESTERGREN     => 'numeric',
            self::HEMA_DIFFERENTIAL_COUNT => 'label',
            self::HEMA_NEUTROPHILS        => 'numeric',
            self::HEMA_SEGMENTERS         => 'text',
            self::HEMA_STAB               => 'text',
            self::HEMA_EOSINOPHILS        => 'numeric',
            self::HEMA_BASOPHILS          => 'numeric',
            self::HEMA_LYMPHOCYTES        => 'numeric',
            self::HEMA_MONOCYTES          => 'numeric',

            // Urinalysis
            self::URI_PHYSICAL_PROPERTIES         => 'label',
            self::URI_COLOR                       => 'text',
            self::URI_TRANSPARENCY                => 'text',
            self::URI_REACTION                    => 'text',
            self::URI_SPECIFIC_GRAVITY            => 'text',
            self::URI_CHEMICAL_PROPERTIES         => 'label',
            self::URI_SUGAR                       => 'text',
            self::URI_PROTEIN                     => 'text',
            self::URI_CHEMICAL_PROPERTIES_OTHERS  => 'text',
            self::URI_MICROSCOPIC_FINDINGS        => 'label',
            self::URI_PUS_CELL                    => 'numeric',
            self::URI_RED_BLOOD_CELL              => 'numeric',
            self::URI_CRYSTAL                     => 'numeric',
            self::URI_CAST                        => 'numeric',
            self::URI_AMOURPHOUS_URATE_PHOSPATE   => 'text',
            self::URI_SQUAMOUS_EPITHELIAL_CELL    => 'text',
            self::URI_ROUND_EPITHELIAL_CELL       => 'text',
            self::URI_MUCUS_THREAD                => 'text',
            self::URI_BACTERIA                    => 'text',
            self::URI_MICROSCOPIC_FINDINGS_OTHERS => 'text',

            // Fecalysis
            self::FECA_PHYSICAL                          => 'label',
            self::FECA_COLOR                             => 'text',
            self::FECA_CONSISTENCY                       => 'text',
            self::FECA_BLOOD                             => 'text',
            self::FECA_MUCUS                             => 'text',
            self::FECA_CHEMICAL                          => 'label',
            self::FECA_OCCULT_BLOOD                      => 'text',
            self::FECA_CHEMICAL_OTHERS                   => 'text',
            self::FECA_MICROSCOPIC                       => 'label',
            self::FECA_ASCARIS                           => 'text',
            self::FECA_HOOKWORM                          => 'text',
            self::FECA_TRICHURIS                         => 'text',
            self::FECA_STRONGYLOIDES                     => 'text',
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST => 'numeric',
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE => 'numeric',
            self::FECA_ENTAMOEBA_COLI_CYST               => 'numeric',
            self::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE => 'numeric',
            self::FECA_BLASTOCYSTIS_SPP                  => 'numeric',
            self::FECA_MICROSCOPIC_OTHERS                => 'numeric',
            self::FECA_CELLULAR_ELEMENTS                 => 'label',
            self::FECA_PUS_CELL                          => 'numeric',
            self::FECA_RED_BLOOD_CELL                    => 'numeric',
            self::FECA_YEAST_CELL                        => 'text',
            self::FECA_FAT_GLOBULES                      => 'text',
            self::FECA_BACTERIA                          => 'text',
            self::FECA_CELLULAR_OTHERS                   => 'text',

            // Miscellaneous
            self::DENGUE_NS1_ANTIGEN            => 'text',
            self::DENGUE_IGM_ANTIBODY           => 'text',
            self::DENGUE_IGG_ANTIBODY           => 'text',
            self::SALMONELLA_TYPHI_IGM_ANTIBODY => 'text',
            self::SALMONELLA_TYPHI_IGG_ANTIBODY => 'text',
            self::PREGNANCY_URINE_RESULT_TEXT   => 'text',
            self::PREGNANCY_SERUM_RESULT_TEXT   => 'text',
            self::RPR_ANTI_TP_RESULT_TEXT       => 'text',
            self::HBSAG_RESULT_TEXT             => 'text',
            self::CRP_QUANTITATIVE_RESULT_TEXT  => 'text',
            self::H_PYLORI_RESULT_TEXT          => 'text',
        };
    }

    public function normalRange(): ?array
    {
        return match ($this) {
            // Clinical Chemistry
            self::FBS => [
                'both_min'   => 3.3,
                'both_max'   => 5.6,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::RBS => [
                'both_min'   => null,
                'both_max'   => 7.7,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::BUN => [
                'both_min'   => 2.14,
                'both_max'   => 7.14,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::CREATININE => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 53,
                'male_max'   => 115,
                'female_min' => 44,
                'female_max' => 97,
            ],
            self::URIC_ACID => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 210,
                'male_max'   => 420,
                'female_min' => 150,
                'female_max' => 360,
            ],
            self::SGPT_ALT => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => null,
                'male_max'   => 41,
                'female_min' => null,
                'female_max' => 31,
            ],
            self::SGOT_AST => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => null,
                'male_max'   => 40,
                'female_min' => null,
                'female_max' => 32,
            ],
            self::LIPID_PROFILE     => null,
            self::TOTAL_CHOLESTEROL => [
                'both_min'   => null,
                'both_max'   => 5.2,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::TRIGLYCERIDES => [
                'both_min'   => null,
                'both_max'   => 1.694,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HDL_CHOLESTEROL => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 1.03,
                'male_max'   => null,
                'female_min' => 1.29,
                'female_max' => null,
            ],
            self::LDL_CHOLESTEROL => [
                'both_min'   => null,
                'both_max'   => 2.59,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::SODIUM => [
                'both_min'   => 135,
                'both_max'   => 146,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::POTASSIUM => [
                'both_min'   => 3.5,
                'both_max'   => 5.2,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::CHLORIDE => [
                'both_min'   => 97,
                'both_max'   => 109,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::IONIZED_CALCIUM => [
                'both_min'   => 1.1,
                'both_max'   => 1.29,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::IONIZED_MAGNESIUM => [
                'both_min'   => 0.41,
                'both_max'   => 0.63,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::FIRST_HOUR => [
                'both_min'   => null,
                'both_max'   => 9.9,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::SECOND_HOUR => [
                'both_min'   => null,
                'both_max'   => 8.4,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HBA1C => [
                'both_min'   => 4.0,
                'both_max'   => 6.5,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],

            // Hematology
            self::HEMA_BLOOD_STUDIES => null,
            self::HEMA_HEMOGLOBIN    => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 140,
                'male_max'   => 180,
                'female_min' => 120,
                'female_max' => 160,
            ],
            self::HEMA_HEMATOCRIT => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 0.41,
                'male_max'   => 0.47,
                'female_min' => 0.36,
                'female_max' => 0.41,
            ],
            self::HEMA_RBC_COUNT => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 4.6,
                'male_max'   => 6.2,
                'female_min' => 4.2,
                'female_max' => 5.4,
            ],
            self::HEMA_WBC_COUNT => [
                'both_min'   => 4.5,
                'both_max'   => 11,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_PLATELET_COUNT => [
                'both_min'   => 150,
                'both_max'   => 450,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_NUCLEATED_RBCS => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_BLOOD_TYPE        => null,
            self::HEMA_BLEEDING_TIME_MIN => [
                'both_min'   => 1,
                'both_max'   => 5,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_BLEEDING_TIME_SEC => [
                'both_min'   => 1,
                'both_max'   => 5,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_CLOTTING_TIME_MIN => [
                'both_min'   => 2,
                'both_max'   => 7,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_CLOTTING_TIME_SEC => [
                'both_min'   => 2,
                'both_max'   => 7,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_ESR_WESTERGREN => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 0,
                'male_max'   => 10,
                'female_min' => 0,
                'female_max' => 20,
            ],
            self::HEMA_DIFFERENTIAL_COUNT => null,
            self::HEMA_NEUTROPHILS        => [
                'both_min'   => 0.36,
                'both_max'   => 0.66,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_SEGMENTERS  => null,
            self::HEMA_STAB        => null,
            self::HEMA_EOSINOPHILS => [
                'both_min'   => 0.02,
                'both_max'   => 0.04,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_BASOPHILS => [
                'both_min'   => 0.00,
                'both_max'   => 0.01,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_LYMPHOCYTES => [
                'both_min'   => 0.24,
                'both_max'   => 0.44,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HEMA_MONOCYTES => [
                'both_min'   => 0.02,
                'both_max'   => 0.06,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],

            // Urinalysis
            self::URI_PHYSICAL_PROPERTIES         => null,
            self::URI_COLOR                       => null,
            self::URI_TRANSPARENCY                => null,
            self::URI_REACTION                    => null,
            self::URI_SPECIFIC_GRAVITY            => null,
            self::URI_CHEMICAL_PROPERTIES         => null,
            self::URI_SUGAR                       => null,
            self::URI_PROTEIN                     => null,
            self::URI_CHEMICAL_PROPERTIES_OTHERS  => null,
            self::URI_MICROSCOPIC_FINDINGS        => null,
            self::URI_PUS_CELL                    => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::URI_RED_BLOOD_CELL              => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::URI_CRYSTAL                     => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::URI_CAST                        => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::URI_AMOURPHOUS_URATE_PHOSPATE   => null,
            self::URI_SQUAMOUS_EPITHELIAL_CELL    => null,
            self::URI_ROUND_EPITHELIAL_CELL       => null,
            self::URI_MUCUS_THREAD                => null,
            self::URI_BACTERIA                    => null,
            self::URI_MICROSCOPIC_FINDINGS_OTHERS => null,

            // Fecalysis
            self::FECA_PHYSICAL                          => null,
            self::FECA_COLOR                             => null,
            self::FECA_CONSISTENCY                       => null,
            self::FECA_BLOOD                             => null,
            self::FECA_MUCUS                             => null,
            self::FECA_CHEMICAL                          => null,
            self::FECA_OCCULT_BLOOD                      => null,
            self::FECA_CHEMICAL_OTHERS                   => null,
            self::FECA_MICROSCOPIC                       => null,
            self::FECA_ASCARIS                           => null,
            self::FECA_HOOKWORM                          => null,
            self::FECA_TRICHURIS                         => null,
            self::FECA_STRONGYLOIDES                     => null,
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_ENTAMOEBA_COLI_CYST               => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_BLASTOCYSTIS_SPP                  => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_MICROSCOPIC_OTHERS                => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_CELLULAR_ELEMENTS                 => null,
            self::FECA_PUS_CELL                          => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_RED_BLOOD_CELL                    => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_YEAST_CELL                        => null,
            self::FECA_FAT_GLOBULES                      => null,
            self::FECA_BACTERIA                          => null,
            self::FECA_CELLULAR_OTHERS                   => null,

            // Miscellaneous
            self::DENGUE_NS1_ANTIGEN            => null,
            self::DENGUE_IGM_ANTIBODY           => null,
            self::DENGUE_IGG_ANTIBODY           => null,
            self::SALMONELLA_TYPHI_IGM_ANTIBODY => null,
            self::SALMONELLA_TYPHI_IGG_ANTIBODY => null,
            self::PREGNANCY_URINE_RESULT_TEXT   => null,
            self::PREGNANCY_SERUM_RESULT_TEXT   => null,
            self::RPR_ANTI_TP_RESULT_TEXT       => null,
            self::HBSAG_RESULT_TEXT             => null,
            self::CRP_QUANTITATIVE_RESULT_TEXT  => null,
            self::H_PYLORI_RESULT_TEXT          => null,
        };
    }

    public function unit(): ?string
    {
        return match ($this) {
            // Clinical Chemistry
            self::FBS               => 'mmol/L',
            self::RBS               => 'mmol/L',
            self::BUN               => 'mmol/L',
            self::CREATININE        => 'umol/L',
            self::URIC_ACID         => 'umol/L',
            self::SGPT_ALT          => 'U/L',
            self::SGOT_AST          => 'U/L',
            self::LIPID_PROFILE     => null,
            self::TOTAL_CHOLESTEROL => 'mmol/L',
            self::TRIGLYCERIDES     => 'mmol/L',
            self::HDL_CHOLESTEROL   => 'mmol/L',
            self::LDL_CHOLESTEROL   => 'mmol/L',
            self::SODIUM            => 'mmol/L',
            self::POTASSIUM         => 'mmol/L',
            self::CHLORIDE          => 'mmol/L',
            self::IONIZED_CALCIUM   => 'mmol/L',
            self::IONIZED_MAGNESIUM => 'mmol/L',
            self::FIRST_HOUR        => 'mmol/L',
            self::SECOND_HOUR       => 'mmol/L',
            self::HBA1C             => '%',

            // Hematology
            self::HEMA_BLOOD_STUDIES      => null,
            self::HEMA_HEMOGLOBIN         => 'gm/L',
            self::HEMA_HEMATOCRIT         => 'volFl',
            self::HEMA_RBC_COUNT          => 'x 10¹²/L',
            self::HEMA_WBC_COUNT          => 'x 10⁹/L',
            self::HEMA_PLATELET_COUNT     => 'x 10⁹/L',
            self::HEMA_NUCLEATED_RBCS     => '/100 WBCs',
            self::HEMA_BLOOD_TYPE         => null,
            self::HEMA_BLEEDING_TIME_MIN  => 'min',
            self::HEMA_BLEEDING_TIME_SEC  => 'sec',
            self::HEMA_CLOTTING_TIME_MIN  => 'min',
            self::HEMA_CLOTTING_TIME_SEC  => 'sec',
            self::HEMA_ESR_WESTERGREN     => 'mm/hr',
            self::HEMA_DIFFERENTIAL_COUNT => null,
            self::HEMA_NEUTROPHILS        => null,
            self::HEMA_SEGMENTERS         => null,
            self::HEMA_STAB               => null,
            self::HEMA_EOSINOPHILS        => null,
            self::HEMA_BASOPHILS          => null,
            self::HEMA_LYMPHOCYTES        => null,
            self::HEMA_MONOCYTES          => null,

            // Urinalysis
            self::URI_PHYSICAL_PROPERTIES         => null,
            self::URI_COLOR                       => null,
            self::URI_TRANSPARENCY                => null,
            self::URI_REACTION                    => null,
            self::URI_SPECIFIC_GRAVITY            => null,
            self::URI_CHEMICAL_PROPERTIES         => null,
            self::URI_SUGAR                       => null,
            self::URI_PROTEIN                     => null,
            self::URI_CHEMICAL_PROPERTIES_OTHERS  => null,
            self::URI_MICROSCOPIC_FINDINGS        => null,
            self::URI_PUS_CELL                    => '/hpf',
            self::URI_RED_BLOOD_CELL              => '/hpf',
            self::URI_CRYSTAL                     => '/lpf',
            self::URI_CAST                        => '/lpf',
            self::URI_AMOURPHOUS_URATE_PHOSPATE   => null,
            self::URI_SQUAMOUS_EPITHELIAL_CELL    => null,
            self::URI_ROUND_EPITHELIAL_CELL       => null,
            self::URI_MUCUS_THREAD                => null,
            self::URI_BACTERIA                    => null,
            self::URI_MICROSCOPIC_FINDINGS_OTHERS => null,

            // Fecalysis
            self::FECA_PHYSICAL                          => null,
            self::FECA_COLOR                             => null,
            self::FECA_CONSISTENCY                       => null,
            self::FECA_BLOOD                             => null,
            self::FECA_MUCUS                             => null,
            self::FECA_CHEMICAL                          => null,
            self::FECA_OCCULT_BLOOD                      => null,
            self::FECA_CHEMICAL_OTHERS                   => null,
            self::FECA_MICROSCOPIC                       => null,
            self::FECA_ASCARIS                           => null,
            self::FECA_HOOKWORM                          => null,
            self::FECA_TRICHURIS                         => null,
            self::FECA_STRONGYLOIDES                     => null,
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST => '/hpf',
            self::FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST_TROPHOZOITE => '/hpf',
            self::FECA_ENTAMOEBA_COLI_CYST               => '/hpf',
            self::FECA_ENTAMOEBA_COLI_CYST_TROPHOZOITE => '/hpf',
            self::FECA_BLASTOCYSTIS_SPP                  => '/hpf',
            self::FECA_MICROSCOPIC_OTHERS                => '/hpf',
            self::FECA_CELLULAR_ELEMENTS                 => null,
            self::FECA_PUS_CELL                          => '/hpf',
            self::FECA_RED_BLOOD_CELL                    => '/hpf',
            self::FECA_YEAST_CELL                        => null,
            self::FECA_FAT_GLOBULES                      => null,
            self::FECA_BACTERIA                          => null,
            self::FECA_CELLULAR_OTHERS                   => null,

            // Miscellaneous
            self::DENGUE_NS1_ANTIGEN            => null,
            self::DENGUE_IGM_ANTIBODY           => null,
            self::DENGUE_IGG_ANTIBODY           => null,
            self::SALMONELLA_TYPHI_IGM_ANTIBODY => null,
            self::SALMONELLA_TYPHI_IGG_ANTIBODY => null,
            self::PREGNANCY_URINE_RESULT_TEXT   => null,
            self::PREGNANCY_SERUM_RESULT_TEXT   => null,
            self::RPR_ANTI_TP_RESULT_TEXT       => null,
            self::HBSAG_RESULT_TEXT             => null,
            self::CRP_QUANTITATIVE_RESULT_TEXT  => null,
            self::H_PYLORI_RESULT_TEXT          => null,
        };
    }
}
