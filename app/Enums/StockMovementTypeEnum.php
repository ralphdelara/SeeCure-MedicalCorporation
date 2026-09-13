<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum StockMovementTypeEnum: int
{
    use EnumTraits;

    case STOCK_IN = 1;
    case STOCK_OUT = 2;
    case STOCK_OUT_PRESCRIPTION = 3;

    public function description(): string
    {
        return match ($this) {
            self::STOCK_IN               => 'Stock In',
            self::STOCK_OUT              => 'Stock Out',
            self::STOCK_OUT_PRESCRIPTION => 'Stock Out (Prescription)',
        };
    }

    public static function allowedOptions(): array
    {
        return array_filter(self::cases(), fn ($case) => ! in_array($case, [
            self::STOCK_OUT_PRESCRIPTION,
        ]));
    }
}
