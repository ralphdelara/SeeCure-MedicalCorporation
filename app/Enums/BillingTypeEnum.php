<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum BillingTypeEnum: int
{
    use EnumTraits;

    case CONSULTATION = 1; // Billing personel will print prescription and doctor fee
    case LABORATORY = 2; // Billing personel will print laboratory billing
    case RADIOLOGY = 3; // Billing personel will print radiology billing

    public function description(): string
    {
        return match ($this) {
            self::CONSULTATION => 'Consultation',
            self::LABORATORY   => 'Laboratory',
            self::RADIOLOGY    => 'Radiology',
        };
    }
}
