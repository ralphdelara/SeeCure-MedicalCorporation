<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum VitalSignsEnum: int
{
    use EnumTraits;

    case BLOOD_PRESSURE = 1;
    case CARDIAC_RATE = 2;
    case RESPIRATORY_RATE = 3;
    case OXYGEN_SATURATION = 4;
    case BODY_WEIGHT = 5;
    case TEMPERATURE = 6;

    public function description(): string
    {
        return match ($this) {
            self::BLOOD_PRESSURE    => 'Blood Pressure (BP)',
            self::CARDIAC_RATE      => 'Cardiac Rate (CR)',
            self::RESPIRATORY_RATE  => 'Respiratory Rate (RR)',
            self::OXYGEN_SATURATION => 'Oxygen Saturation (O₂Sat)',
            self::BODY_WEIGHT       => 'Body Weight (BW)',
            self::TEMPERATURE       => 'Temperature (Temp)',
        };
    }
}
