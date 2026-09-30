<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum NationalityEnum: int
{
    use EnumTraits;

    case FILIPINO = 1;

    public function description(): string
    {
        return match ($this) {
            self::FILIPINO  => 'Filipino',
        };
    }
}
