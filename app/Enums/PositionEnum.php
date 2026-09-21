<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum PositionEnum: int
{
    use EnumTraits;

    case HEAD_OF_ADMIN = 1;
    case ADMIN_AIDE = 2;
    case HEAD_OF_FINANCE = 3;
    case ACCOUNTANT = 4;
    case FINANCE_OFFICER = 5;
    case GENERAL_PRACTITIONER = 6;
    case PHARMACIST = 7;
    case INVENTORY_ASSISTANT = 8;
    case HEAD_OF_LABORATORY = 9;
    case MEDICAL_TECHNOLOGIST_SUPERVISOR = 10;
    case MEDICAL_TECHNOLOGIST = 11;
    case LABORATORY_AIDE = 12;
    case SOFTWARE_ENGINEER = 13;
    case BOT = 14;
    case ENCODER = 15;
    case STAFF = 16;
    case NURSE = 17;

    public function description(): string
    {
        return match ($this) {
            self::HEAD_OF_ADMIN                   => 'Head Of Admin',
            self::ADMIN_AIDE                      => 'Admin Aide',
            self::HEAD_OF_FINANCE                 => 'Head Of Finance',
            self::ACCOUNTANT                      => 'Accountant',
            self::FINANCE_OFFICER                 => 'Finance Officer',
            self::GENERAL_PRACTITIONER            => 'General Practitioner',
            self::PHARMACIST                      => 'Pharmacist',
            self::INVENTORY_ASSISTANT             => 'Inventory Assistant',
            self::HEAD_OF_LABORATORY              => 'Head Of Laboratory',
            self::MEDICAL_TECHNOLOGIST_SUPERVISOR => 'Medical Technologist Supervisor',
            self::MEDICAL_TECHNOLOGIST            => 'Medical Technologist',
            self::LABORATORY_AIDE                 => 'Laboratory Aide',
            self::SOFTWARE_ENGINEER               => 'Software Engineer',
            self::BOT                             => 'Bot',
            self::ENCODER                         => 'Encoder',
            self::STAFF                           => 'Staff',
            self::NURSE                           => 'Nurse',
        };
    }
}
