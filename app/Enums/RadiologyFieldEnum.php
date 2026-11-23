<?php

use App\Traits\EnumTraits;

enum RadiologyFieldEnum: int
{
    use EnumTraits;

    case FINDINGS = 1;
    case IMPRESSIONS = 2;
    case LEFT_BREAST = 3;
    case RIGHT_BREAST = 4;
    
    public function description(): string
    {
        return match ($this) {
            self::FINDINGS => 'Findings',
            self::IMPRESSIONS => 'Impressions',
            self::LEFT_BREAST => 'Left Breast',
            self::RIGHT_BREAST => 'Right Breast',
        };
    }
}