<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EncryptedDate implements CastsAttributes
{
    /**
     * Cast the given value after decryption.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Carbon
    {
        return $value !== null ? Carbon::parse(decrypt($value)) : null;
    }

    /**
     * Prepare the given value for storage after encryption.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        // Standardize the date format before encrypting
        $date = $value instanceof Carbon ? $value : Carbon::parse($value);

        return encrypt($date->toDateString()); // Use ->toDateTimeString() for datetime columns
    }
}
