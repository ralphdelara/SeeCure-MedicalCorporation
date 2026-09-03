<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum SignsOrSymptomEnum: int
{
    use EnumTraits;

    case COUGH = 1;
    case COLDS = 2;
    case FEVER = 3;
    case HEADACHE = 4;
    case STOMACH_PAIN = 5;
    case SORE_THROAT = 6;
    case DIFFICULTY_OF_BREATHING = 7;
    case DIARRHEA = 8;
    case LOSS_OF_SMELL = 9;
    case LOSS_OF_TASTE = 10;

    public function description(): string
    {
        return match ($this) {
            self::COUGH                   => 'Cough',
            self::COLDS                   => 'Colds',
            self::FEVER                   => 'Fever',
            self::HEADACHE                => 'Headache',
            self::STOMACH_PAIN            => 'Stomach Pain',
            self::SORE_THROAT             => 'Sorethroat',
            self::DIFFICULTY_OF_BREATHING => 'Difficulty of Breathing',
            self::DIARRHEA                => 'Diarrhea',
            self::LOSS_OF_SMELL           => 'Loss of Smell',
            self::LOSS_OF_TASTE           => 'Loss of Taste',
        };
    }
}
