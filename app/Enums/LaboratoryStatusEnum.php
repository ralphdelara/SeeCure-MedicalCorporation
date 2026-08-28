<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum LaboratoryStatusEnum: int
{
    use EnumTraits;

    case PENDING = 1; // Patient still need to complete laboratory and/or radiology first
    case READY_FOR_LABORATORY = 2; // Patient is done with radiology or consultation
    case COMPLETED = 3; // If Staff is done with lab test
    case CANCELLED = 4; // To be set by Staff if patient decided to cancel test

    public function description(): string
    {
        return match ($this) {
            self::PENDING              => 'Pending',
            self::READY_FOR_LABORATORY => 'Ready for Laboratory',
            self::COMPLETED            => 'Completed',
            self::CANCELLED            => 'Cancelled',
        };
    }

    public static function incompleteStatuses(): array
    {
        return [
            self::PENDING->value,
            self::READY_FOR_LABORATORY->value,
        ];
    }

    public static function incompleteStatusesDropdown(): array
    {
        return [
            ['id' => self::PENDING->value, 'name' => self::PENDING->description()],
            ['id' => self::READY_FOR_LABORATORY->value, 'name' => self::READY_FOR_LABORATORY->description()],
        ];
    }
}
