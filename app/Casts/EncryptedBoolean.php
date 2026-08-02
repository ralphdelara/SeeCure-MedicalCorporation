<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptedBoolean implements CastsAttributes
{
    /**
     * Cast the given value after decryption.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?bool
    {
        return Crypt::encryptString((bool) $value ? '1' : '0');
    }

    /**
     * Prepare the given value for storage after encryption.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?bool
    {
        if (is_null($value)) {
            return false;
        }

        return Crypt::decryptString($value) === '1';
    }
}
