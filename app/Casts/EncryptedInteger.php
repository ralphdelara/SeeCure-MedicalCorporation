<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptedInteger implements CastsAttributes
{
    /**
     * Cast the given value after decryption.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return Crypt::encryptString((string) $value);
    }

    /**
     * Prepare the given value for storage after encryption.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return (int) Crypt::decryptString($value);
    }
}
