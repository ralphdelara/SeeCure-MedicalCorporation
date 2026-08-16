<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EncryptedInteger implements CastsAttributes
{
    /**
     * Cast the given value after decryption.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return $value !== null ? (int) decrypt($value) : null;
    }

    /**
     * Prepare the given value for storage after encryption.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        return encrypt($value);
    }
}
