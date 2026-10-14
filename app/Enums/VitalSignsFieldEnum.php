<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum VitalSignsFieldEnum: int
{
    use EnumTraits;

    case SYSTOLIC = 1;
    case DIASTOLIC = 2;
    case CARDIAC_RATE = 3;
    case RESPIRATORY_RATE = 4;
    case PERCENTAGE = 5;
    case WEIGHT = 6;
    case DEGREES = 7;

    public function description(): string
    {
        return match ($this) {
            self::SYSTOLIC         => 'Systolic',
            self::DIASTOLIC        => 'Diastolic',
            self::CARDIAC_RATE     => 'Rate',
            self::RESPIRATORY_RATE => 'Rate',
            self::PERCENTAGE       => 'Percentage',
            self::WEIGHT           => 'Weight',
            self::DEGREES          => 'Degrees',
        };
    }
}
