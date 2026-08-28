<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum ConsultationStatusEnum: int
{
    use EnumTraits;

    case PENDING = 1; // Patient still need to complete laboratory and/or radiology first
    case READY_FOR_CONSULTATION = 2; // Patient is done with laboratory and/or radiology
    case FOLLOW_UP = 3; // If Doctor sets follow up date
    case COMPLETED = 4; // If Doctor is done with consultation
    case CANCELLED = 5; // To be set by doctor if patient decided to cancel consultation

    public function description(): string
    {
        return match ($this) {
            self::PENDING                => 'Pending',
            self::READY_FOR_CONSULTATION => 'Ready for Consultation',
            self::FOLLOW_UP              => 'Follow Up',
            self::COMPLETED              => 'Completed',
            self::CANCELLED              => 'Cancelled',
        };
    }

    public static function incompleteStatuses(): array
    {
        return [
            self::PENDING->value,
            self::READY_FOR_CONSULTATION->value,
            self::FOLLOW_UP->value,
        ];
    }

    public static function incompleteStatusesDropdown(): array
    {
        return [
            ['id' => self::PENDING->value, 'name' => self::PENDING->description()],
            ['id' => self::READY_FOR_CONSULTATION->value, 'name' => self::READY_FOR_CONSULTATION->description()],
            ['id' => self::FOLLOW_UP->value, 'name' => self::FOLLOW_UP->description()],
        ];
    }
}
