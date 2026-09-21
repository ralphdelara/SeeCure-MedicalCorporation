<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum DocumentTypeEnum: int
{
    use EnumTraits;

    case MEDICAL_CERTIFICATE = 1;
    case REFERRAL_LETTER = 2;
    case FILE = 3;

    public function description(): string
    {
        return match ($this) {
            self::MEDICAL_CERTIFICATE => 'Medical Certificate',
            self::REFERRAL_LETTER     => 'Referral Letter',
            self::FILE                => 'File',
        };
    }
}
