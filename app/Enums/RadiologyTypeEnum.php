<?php

use App\Traits\EnumTraits;

enum RadiologyTypeEnum: int
{
    use EnumTraits;

    case ABDOMEN_AND_GENERAL_UTZ = 1;
    case WOMENS_HEALTH_ULTRASOUND = 2;
    case OTHER_ULTRASOUND = 3;
    
    public function description(): string
    {
        return match ($this) {
            self::ABDOMEN_AND_GENERAL_UTZ => 'Abdomen & General UTZ',
            self::WOMENS_HEALTH_ULTRASOUND => 'Women\'s Health Ultrasound',
            self::OTHER_ULTRASOUND => 'Other Ultrasound',
        };
    }
}