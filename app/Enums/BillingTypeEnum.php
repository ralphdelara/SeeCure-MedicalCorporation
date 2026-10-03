<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum BillingTypeEnum: int
{
    use EnumTraits;

    case CONSULTATION = 1;
    case LABORATORY = 2;
    case RADIOLOGY = 3;
    case SUPPLIES = 4;

    public function description(): string
    {
        return match ($this) {
            self::CONSULTATION => 'Consultation',
            self::LABORATORY   => 'Laboratory',
            self::RADIOLOGY    => 'Radiology',
            self::SUPPLIES     => 'Supplies',
        };
    }
}
