<?php

namespace App\Traits;

/**
 * @method static array cases()
 */
trait EnumTraits
{
    public static function getArrayList(): array
    {
        return array_map(fn ($case) => [
            'id'   => $case->value,
            'name' => $case->description(),
        ], self::cases());
    }

    public static function getDescriptionLists(): array
    {
        $list = [];

        foreach (self::cases() as $case) {
            $list[$case->value] = $case->description();
        }

        return $list;
    }
}
