<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum PaymentMethodEnum: int
{
    use EnumTraits;

    case CASH = 1;
    case CARD = 2;
    case GCASH = 3;
    case MAYA = 4;

    public function description(): string
    {
        return match ($this) {
            self::CASH  => 'Cash',
            self::CARD  => 'Card',
            self::GCASH => 'GCash',
            self::MAYA  => 'Maya',
        };
    }
}
