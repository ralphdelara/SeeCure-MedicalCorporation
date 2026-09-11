<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum PaymentStatusEnum: int
{
    use EnumTraits;

    case PENDING = 1;
    case SUCCESS = 2;
    case FAILED = 3;

    public function description(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::FAILED  => 'Failed',
        };
    }
}
