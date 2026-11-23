<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum RadiologyTestEnum: int
{
    use EnumTraits;
    // ABDOMEN & GENERAL UTZ
    case HBT = 1;
    case HBT_PLUS_PANCREAS = 2;
    case KUB = 3;
    case KUB_PLUS_PROSTATE = 4;
    case KUB_PLUS_PROSTATE_PREVOID_POSTVOID = 5;
    case UPPER_ABDOMEN = 6;
    case WHOLE_ABDOMEN = 7;
    case WHOLE_ABDOMEN_PLUS_PREVOID_POSTVOID = 8;
    case ONE_ORGAN = 9;
    case SOFT_TISSUE = 10;
    case PROSTATE = 11;

    // WOMEN'S HEALTH ULTRASOUND
    case AMNIOTIC_FLUID = 12;
    case TRANSAB_PELVIC_SINGLE = 13;
    case TRANSAB_PELVIC_TWINS = 14;
    case TRANSVAGINAL_UTZ = 15;
    case TRANSRECTAL_UTZ = 16;
    case NON_PREGNANT_PELVIC_UTZ = 17;

    // OTHER ULTRASOUND
    case BREAST_UTZ = 18;
    case CRANIAL = 19;
    case NECK_THYROID_OR_PAROTID = 20;
    case SCROTAL_UTZ = 21;
    case INGUINOSCROTAL = 22;
    case CHEST_UTZ = 23;
    case CHEST_UTZ_WITH_MAPPING = 24;

    /**
     * Get the clean display name for each laboratory test.
     */
    public function description(): string
    {
        return match ($this) {
            // ABDOMEN & GENERAL UTZ
            self::HBT => 'HBT',
            self::HBT_PLUS_PANCREAS => 'HBT + Pancreas',
            self::KUB => 'KUB',
            self::KUB_PLUS_PROSTATE => 'KUB + Prostate',
            self::KUB_PLUS_PROSTATE_PREVOID_POSTVOID => 'KUB + Prostate (Prevoid/Postvoid)',
            self::UPPER_ABDOMEN => 'Upper Abdomen',
            self::WHOLE_ABDOMEN => 'Whole Abdomen',
            self::WHOLE_ABDOMEN_PLUS_PREVOID_POSTVOID => 'Whole Abdomen + Prevoid/Postvoid',
            self::ONE_ORGAN => 'One Organ',
            self::SOFT_TISSUE => 'Soft Tissue',
            self::PROSTATE => 'Prostate',

            // WOMEN'S HEALTH ULTRASOUND
            self::AMNIOTIC_FLUID => 'Amniotic Fluid',
            self::TRANSAB_PELVIC_SINGLE => 'Transabdominal Pelvic (Single)',
            self::TRANSAB_PELVIC_TWINS => 'Transabdominal Pelvic (Twins)',
            self::TRANSVAGINAL_UTZ => 'Transvaginal UTZ',
            self::TRANSRECTAL_UTZ => 'Transrectal UTZ',
            self::NON_PREGNANT_PELVIC_UTZ => 'Non-Pregnant Pelvic UTZ',

            // OTHER ULTRASOUND
            self::BREAST_UTZ => 'Breast UTZ',
            self::CRANIAL => 'Cranial',
            self::NECK_THYROID_OR_PAROTID => 'Neck / Thyroid / Parotid',
            self::SCROTAL_UTZ => 'Scrotal UTZ',
            self::INGUINOSCROTAL => 'Inguinoscrotal',
            self::CHEST_UTZ => 'Chest UTZ',
            self::CHEST_UTZ_WITH_MAPPING => 'Chest UTZ with Mapping',
        };
    }

    public function price(): float
    {
        return match ($this) {
            // ABDOMEN & GENERAL UTZ
            self::HBT => 1100,
            self::HBT_PLUS_PANCREAS => 1300,
            self::KUB => 1200,
            self::KUB_PLUS_PROSTATE => 1400,
            self::KUB_PLUS_PROSTATE_PREVOID_POSTVOID => 1500,
            self::UPPER_ABDOMEN => 1200,
            self::WHOLE_ABDOMEN => 1900,
            self::WHOLE_ABDOMEN_PLUS_PREVOID_POSTVOID => 2100,
            self::ONE_ORGAN => 1100,
            self::SOFT_TISSUE => 1200,
            self::PROSTATE => 1200,

            // WOMEN'S HEALTH ULTRASOUND
            self::AMNIOTIC_FLUID => 900,
            self::TRANSAB_PELVIC_SINGLE => 1300,
            self::TRANSAB_PELVIC_TWINS => 1700,
            self::TRANSVAGINAL_UTZ => 1350,
            self::TRANSRECTAL_UTZ => 1800,
            self::NON_PREGNANT_PELVIC_UTZ => 1200,

            // OTHER ULTRASOUND
            self::BREAST_UTZ => 1500,
            self::CRANIAL => 1600,
            self::NECK_THYROID_OR_PAROTID => 1700,
            self::SCROTAL_UTZ => 1500,
            self::INGUINOSCROTAL => 1700,
            self::CHEST_UTZ => 1500,
            self::CHEST_UTZ_WITH_MAPPING => 2000,
        };
    }

    public function testFields(): array
    {
        return match ($this) {
            // ABDOMEN & GENERAL UTZ
            self::HBT => [
                RadiologyFieldEnum::FINDINGS,
                RadiologyFieldEnum::IMPRESSIONS,
            ],
            self::HBT_PLUS_PANCREAS => [
                RadiologyFieldEnum::FINDINGS,
                RadiologyFieldEnum::IMPRESSIONS,
            ],
            self::KUB => [
                RadiologyFieldEnum::FINDINGS,
                RadiologyFieldEnum::IMPRESSIONS,
            ],
            self::KUB_PLUS_PROSTATE => [
                RadiologyFieldEnum::FINDINGS,
                RadiologyFieldEnum::IMPRESSIONS,
            ],
            self::KUB_PLUS_PROSTATE_PREVOID_POSTVOID => 1500,
            self::UPPER_ABDOMEN => 1200,
            self::WHOLE_ABDOMEN => 1900,
            self::WHOLE_ABDOMEN_PLUS_PREVOID_POSTVOID => 2100,
            self::ONE_ORGAN => 1100,
            self::SOFT_TISSUE => 1200,
            self::PROSTATE => 1200,

            // WOMEN'S HEALTH ULTRASOUND
            self::AMNIOTIC_FLUID => 900,
            self::TRANSAB_PELVIC_SINGLE => 1300,
            self::TRANSAB_PELVIC_TWINS => 1700,
            self::TRANSVAGINAL_UTZ => 1350,
            self::TRANSRECTAL_UTZ => 1800,
            self::NON_PREGNANT_PELVIC_UTZ => 1200,

            // OTHER ULTRASOUND
            self::BREAST_UTZ => 1500,
            self::CRANIAL => 1600,
            self::NECK_THYROID_OR_PAROTID => 1700,
            self::SCROTAL_UTZ => 1500,
            self::INGUINOSCROTAL => 1700,
            self::CHEST_UTZ => 1500,
            self::CHEST_UTZ_WITH_MAPPING => 2000,
        };
    }
}
