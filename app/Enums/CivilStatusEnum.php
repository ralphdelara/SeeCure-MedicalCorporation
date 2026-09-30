<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum CivilStatusEnum: int
{
    use EnumTraits;

    case SINGLE = 1;
    case MARRIED = 2;
    case WIDOWED = 3;
    case DIVORCED = 4;
    case SEPARATED = 5;
    case ANNULLED = 6;
    case COHABITING_COMMON_LAW = 7;
    case REGISTERED_PARTNERS = 8;
    case NEWBORN = 9;
    case CHILD = 10;

    public function description(): string
    {
        return match ($this) {
            self::SINGLE                => 'Single',
            self::MARRIED               => 'Married',
            self::WIDOWED               => 'Widowed',
            self::DIVORCED              => 'Divorced',
            self::SEPARATED             => 'Separated',
            self::ANNULLED              => 'Annulled',
            self::COHABITING_COMMON_LAW => 'Cohabiting/Common-law',
            self::REGISTERED_PARTNERS   => 'Registered Partnership',
            self::NEWBORN               => 'Newborn',
            self::CHILD                 => 'Child',
        };
    }
}
