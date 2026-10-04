<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum DiscountTypeEnum: int
{
    use EnumTraits;

    case SENIOR = 1;
    case PWD = 2;
    case PROMO = 3;
    case NAAC = 4;
    case SP = 5;
    case MOV = 6;

    public function description(): string
    {
        return match ($this) {
            self::SENIOR => 'Senior',
            self::PWD    => 'PWD',
            self::PROMO  => 'Promo',
            self::NAAC   => 'National Athlete and Coach',
            self::SP     => 'Solo Parent',
            self::MOV    => 'Medal of Valor',
        };
    }
}
