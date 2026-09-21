<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum ProfessionEnum: int
{
    use EnumTraits;

    case DOCTOR = 1;
    case MEDICAL_TECHNOLOGIST = 2;
    case NURSE = 3;
    case STAFF = 4;
    case IT = 5;
    case PHARMACIST = 6;
    case OTHERS = 7;

    public function description(): string
    {
        return match ($this) {
            self::DOCTOR               => 'Head Of Admin',
            self::MEDICAL_TECHNOLOGIST => 'Admin Aide',
            self::NURSE                => 'Nurse',
            self::STAFF                => 'Staff',
            self::IT                   => 'Information Technology',
            self::PHARMACIST           => 'Pharmacist',
            self::OTHERS               => 'Others',
        };
    }
}
