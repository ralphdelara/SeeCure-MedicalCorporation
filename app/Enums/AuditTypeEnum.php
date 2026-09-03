<?php

namespace App\Enums;

use App\Traits\EnumTraits;

enum AuditTypeEnum: int
{
    use EnumTraits;

    case ADD = 1;
    case UPDATE = 2;
    case DELETE = 3;
    case VIEW = 4;

    public function description(): string
    {
        return match ($this) {
            self::ADD    => 'Add',
            self::UPDATE => 'Update',
            self::DELETE => 'Delete',
            self::VIEW   => 'View',
        };
    }
}
