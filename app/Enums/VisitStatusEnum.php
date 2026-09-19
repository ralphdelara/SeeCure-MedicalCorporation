<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum VisitStatusEnum: int
{
    use EnumTraits;

    case IN_BILLING = 1;
    case IN_CASHIER = 2;
    case IN_LABORATORY = 3;
    case IN_RADIOLOGY = 4;
    case IN_CONSULTATION = 5;
    case IN_PHARMACY = 6;
    case COMPLETED = 7; // for outpatient
    case ADMITTED = 8; // for inpatient / admitted
    case DISCHARGED = 9; // for inpatient / admitted
    case CANCELLED = 10; // for patient that cancelled

    public function description(): string
    {
        return match ($this) {
            self::IN_BILLING      => 'In Billing',
            self::IN_CASHIER      => 'In Cashier',
            self::IN_LABORATORY   => 'In Laboratory',
            self::IN_RADIOLOGY    => 'In Radiology',
            self::IN_CONSULTATION => 'In Consultation',
            self::IN_PHARMACY     => 'In Pharmacy',
            self::COMPLETED       => 'Completed',
            self::ADMITTED        => 'Admitted',
            self::DISCHARGED      => 'Discharged',
            self::CANCELLED       => 'Cancelled',
        };
    }
}
