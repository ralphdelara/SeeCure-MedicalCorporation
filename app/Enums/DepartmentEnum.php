<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum DepartmentEnum: int
{
    use EnumTraits;

    case ADMINISTRATOR = 1;
    case BILLING = 2;
    case CASHIER = 3;
    case CONSULTATION = 4;
    case FRONT_DESK = 5;
    case LABORATORY = 6;
    case RADIOLOGY = 7;
    case PHARMACY = 8;

    public function description(): string
    {
        return match ($this) {
            self::ADMINISTRATOR => 'Administrator',
            self::BILLING       => 'Billing',
            self::CASHIER       => 'Cashier',
            self::CONSULTATION  => 'Consultation',
            self::FRONT_DESK    => 'Front Desk',
            self::LABORATORY    => 'Laboratory',
            self::RADIOLOGY     => 'Radiology',
            self::PHARMACY      => 'Pharmacy',
        };
    }
}
