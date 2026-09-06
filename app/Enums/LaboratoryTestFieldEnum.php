<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryTestFieldEnum: int
{
    use EnumTraits;

    // Clinical Chemistry
    case FBS = 101;
    case RBS = 102;
    case BUN = 103;
    case CREATININE = 104;
    case URIC_ACID = 105;
    case SGPT_ALT = 106;
    case SGOT_AST = 107;
    case LIPID_PROFILE = 108;
    case TOTAL_CHOLESTEROL = 109;
    case TRIGLYCERIDES = 110;
    case HDL_CHOLESTEROL = 111;
    case LDL_CHOLESTEROL = 112;
    case SODIUM = 113;
    case POTASSIUM = 114;
    case CHLORIDE = 115;
    case IONIZED_CALCIUM = 116;
    case IONIZED_MAGNESIUM = 117;
    case FIRST_HOUR = 118;
    case SECOND_HOUR = 119;

    // Hematology
    case HEMA_BLOOD_STUDIES = 200;
    case HEMA_HEMOGLOBIN = 201;
    case HEMA_HEMATOCRIT = 202;
    case HEMA_RBC_COUNT = 203;
    case HEMA_WBC_COUNT = 204;
    case HEMA_PLATELET_COUNT = 205;
    case HEMA_NUCLEATED_RBCS = 206;

    case HEMA_BLOOD_TYPE = 207;
    case HEMA_BLEEDING_TIME_MIN = 208;
    case HEMA_BLEEDING_TIME_SEC = 209;
    case HEMA_CLOTTING_TIME_MIN = 210;
    case HEMA_CLOTTING_TIME_SEC = 211;
    case HEMA_ESR_WESTERGREN = 212;

    case HEMA_DIFFERENTIAL_COUNT = 213;
    case HEMA_NEUTROPHILS = 214;
    case HEMA_SEGMENTERS = 215;
    case HEMA_STAB = 216;
    case HEMA_EOSINOPHILS = 217;
    case HEMA_BASOPHILS = 218;
    case HEMA_LYMPHOCYTES = 219;
    case HEMA_MONOCYTES = 220;

    // Urinalysis
    case URI_PHYSICAL_PROPERTIES = 300;
    case URI_COLOR = 301;
    case URI_TRANSPARENCY = 302;
    case URI_REACTION = 303;
    case URI_SPECIFIC_GRAVITY = 304;
    case URI_CHEMICAL_PROPERTIES = 305;
    case URI_SUGAR = 306;
    case URI_PROTEIN = 307;
    case URI_CHEMICAL_PROPERTIES_OTHERS = 308;
    case URI_MICROSCOPIC_FINDINGS = 309;
    case URI_PUS_CELL = 310;
    case URI_RED_BLOOD_CELL = 311;
    case URI_CRYSTAL = 312;
    case URI_CAST = 313;
    case URI_AMOURPHOUS_URATE_PHOSPATE = 314;
    case URI_SQUAMOUS_EPITHELIAL_CELL = 315;
    case URI_ROUND_EPITHELIAL_CELL = 316;
    case URI_MUCUS_THREAD = 317;
    case URI_BACTERIA = 318;
    case URI_MICROSCOPIC_FINDINGS_OTHERS = 319;

    // Fecalysis
    case FECA_PHYSICAL = 400;
    case FECA_COLOR = 401;
    case FECA_CONSISTENCY = 402;
    case FECA_BLOOD = 403;
    case FECA_MUCUS = 404;
    case FECA_CHEMICAL = 405;
    case FECA_OCCULT_BLOOD = 406;
    case FECA_CHEMICAL_OTHERS = 407;
    case FECA_MICROSCOPIC = 408;
    case FECA_ASCARIS = 409;
    case FECA_HOOKWORM = 410;
    case FECA_TRICHURIS = 411;
    case FECA_STRONGYLOIDES = 412;
    case FECA_ENTAMOEBA_HISTOLYTICA_DISPAR_CYST = 413;
    case FECA_TROPHOZOITE = 414;
    case FECA_ENTAMOEBA_COLI_CYST = 415;
    case FECA_BLASTOCYSTIS_SPP = 416;
    case FECA_MICROSCOPIC_OTHERS = 417;
    case FECA_CELLULAR_ELEMENTS = 418;
    case FECA_PUS_CELL = 419;
    case FECA_RED_BLOOD_CELL = 420;
    case FECA_YEAST_CELL = 421;
    case FECA_FAT_GLOBULES = 422;
    case FECA_BACTERIA = 423;
    case FECA_CELLULAR_OTHERS = 424;

    // Miscellaneous
    case DENGUE_NS1_ANTIGEN = 501;
    case DENGUE_IGM_ANTIBODY = 502;
    case DENGUE_IGG_ANTIBODY = 503;

    case SALMONELLA_TYPHI_IGM_ANTIBODY = 504;
    case SALMONELLA_TYPHI_IGG_ANTIBODY = 505;

    case HBSAG = 506;
    case RPR_ANTI_TP = 507;
    case RESULT_TEXT = 508;

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
            self::FECA_TROPHOZOITE                       => 'Trophozoite',
            self::FECA_ENTAMOEBA_COLI_CYST               => 'Entamoeba coli (Cyst)',
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
            self::HBSAG                         => 'HBsAg',
            self::RPR_ANTI_TP                   => 'RPR / Anti-TP',
            self::RESULT_TEXT                   => 'Result',
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
            self::FECA_TROPHOZOITE                       => 'numeric',
            self::FECA_ENTAMOEBA_COLI_CYST               => 'numeric',
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
            self::HBSAG                         => 'text',
            self::RPR_ANTI_TP                   => 'text',
            self::RESULT_TEXT                   => 'text',
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
                'both_max'   => 5.1,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::TRIGLYCERIDES => [
                'both_min'   => null,
                'both_max'   => 1.693,
                'male_min'   => null,
                'male_max'   => null,
                'female_min' => null,
                'female_max' => null,
            ],
            self::HDL_CHOLESTEROL => [
                'both_min'   => null,
                'both_max'   => null,
                'male_min'   => 1.04,
                'male_max'   => null,
                'female_min' => 1.3,
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
                'both_min'   => 150000,
                'both_max'   => 450000,
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
            self::FECA_TROPHOZOITE                       => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
            self::FECA_ENTAMOEBA_COLI_CYST               => ['both_min' => null, 'both_max' => null, 'male_min' => null, 'male_max' => null, 'female_min' => null, 'female_max' => null],
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
            self::HBSAG                         => null,
            self::RPR_ANTI_TP                   => null,
            self::RESULT_TEXT                   => null,
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
            self::FECA_TROPHOZOITE                       => '/hpf',
            self::FECA_ENTAMOEBA_COLI_CYST               => '/hpf',
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
            self::HBSAG                         => null,
            self::RPR_ANTI_TP                   => null,
            self::RESULT_TEXT                   => null,
        };
    }
}
