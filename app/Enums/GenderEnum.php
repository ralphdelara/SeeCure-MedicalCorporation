<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum GenderEnum: int
{
    use EnumTraits;

    case FEMALE = 1;
    case MALE = 2;
    case OTHERS = 3;
    case UNKNOWN = 4;

    public function description(): string
    {
        return match ($this) {
            self::FEMALE  => 'Female',
            self::MALE    => 'Male',
            self::OTHERS  => 'Others',
            self::UNKNOWN => 'Unknown',
        };
    }
}
