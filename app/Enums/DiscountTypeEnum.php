<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum DiscountTypeEnum: int
{
    use EnumTraits;

    case SENIOR = 1;
    case PWD = 2;
    case PROMO = 3;

    public function description(): string
    {
        return match ($this) {
            self::SENIOR    => 'Senior',
            self::PWD => 'PWD',
            self::PROMO => 'Promo',
        };
    }
}
