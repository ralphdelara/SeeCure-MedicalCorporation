<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum PriorityTypeEnum: int
{
    use EnumTraits;

    case PREGNANT = 1;
    case PERSONS_WITH_DISABILITY = 2;
    case SENIOR_CITIZEN = 3;

    public function description(): string
    {
        return match ($this) {
            self::PREGNANT                => 'Pregnant',
            self::PERSONS_WITH_DISABILITY => 'PWD',
            self::SENIOR_CITIZEN          => 'Senior',
        };
    }
}
