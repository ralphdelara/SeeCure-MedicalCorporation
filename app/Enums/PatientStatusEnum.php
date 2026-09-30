<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum PatientStatusEnum: int
{
    use EnumTraits;

    case INACTIVE = 1;
    case ADMITTED = 2;
    case REFERRED = 3;
    case FOR_DISCHARGE = 4;
    case DISCHARGED = 5;

    public function description(): string
    {
        return match ($this) {
            self::INACTIVE      => 'Inactive',
            self::ADMITTED      => 'Admitted',
            self::REFERRED      => 'Admitted',
            self::FOR_DISCHARGE => 'For Discharge',
            self::DISCHARGED    => 'Discharged',
        };
    }
}
