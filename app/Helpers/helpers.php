<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

if (! function_exists('formatName')) {
    function formatName(string $name)
    {
        // Lowercase everything safely (handles accents/special characters)
        $name = mb_strtolower(trim($name), 'UTF-8');

        // Capitalize letters following spaces, hyphens, or apostrophes
        return preg_replace_callback('/\b\w|(?<=\x27)\w/u', function ($matches) {
            return mb_strtoupper($matches[0], 'UTF-8');
        }, $name);
    }
}

if (! function_exists('updateRelatedData')) {
    /**
     * This function smartly handles related table data when a new entry was entered
     * for example, existing [1, 2, 3], new [3, 4, 5] this function will remove 1, 2
     * then save 4, 5 without 3 on db since 3 already exists
     */
    function updateRelatedData(
        Model $model,
        array $existingIds,
        array $newIds,
        string $parentId, // uuid
        string $parentCol,
        string $childCol,
    ) {
        if (! empty($existingIds)) {
            // ignore update request if theres no changes to prevent deleting existing data
            if (
                empty(array_diff($newIds, $existingIds))
                && empty(array_diff($existingIds, $newIds))
            ) {
                return;
            }

            // removes ids that doesnt exist in new collection of ids
            $model->where($parentCol, $parentId)
                ->whereNotIn($childCol, $newIds)
                ->delete();

            $newIds = array_diff($newIds, $existingIds);
        }

        if (empty($newIds)) {
            return;
        }

        $newIds = array_map(fn ($value) => [
            $parentCol => $parentId,
            $childCol  => $value,
        ], $newIds);

        $model->fillAndInsert($newIds);
    }
}

if (! function_exists('computeExactAge')) {
    function computeExactAge(?string $dateOfBirth, ?string $type = null): string|int|null
    {
        if (empty($dateOfBirth)) {
            return null;
        }

        $dob = new DateTime($dateOfBirth);
        $currentDate = new DateTime;

        $diff = $dob->diff($currentDate);

        if ($type === 'year') {
            return $diff->y;
        }

        return $diff->format('%yy %mm %dd');
    }
}

if (! function_exists('getRelatedAuditFields')) {
    function getRelatedAuditFields(
        array $enumArray = [],
        array $fields = [],
    ): array {
        $newFields = [];

        $newFields['added'] = array_map(function ($id) use ($enumArray) {
            return $enumArray[$id] ?? 'Unknown';
        }, $fields['attached'] ?? []);

        $newFields['deleted'] = array_map(function ($id) use ($enumArray) {
            return $enumArray[$id] ?? 'Unknown';
        }, $fields['detached'] ?? []);

        return $newFields;
    }
}

if (! function_exists('abortIfInvalidUuid')) {
    function abortIfInvalidUuid(
        string $uuid,
    ): void {
        // for postgresql, mysql doesnt need this
        if (! Str::isUuid($uuid)) {
            abort(404);
        }
    }
}

if (! function_exists('customEncrypt')) {
    function customEncrypt(string $string, string $key): string
    {
        $encrypter = new Encrypter($key, 'aes-256-cbc');

        // Encrypt without serialization (equivalent to encryptString)
        return $encrypter->encrypt($string, false);
    }
}

if (! function_exists('customDecrypt')) {
    function customDecrypt(string $string, string $key): string
    {
        $cipher = 'AES-256-CBC';
        $encrypter = new Encrypter($key, config('app.document_validate_cipher'));
        // Decrypt without serialization (equivalent to decryptString)
        try {
            $decrypted = $encrypter->decrypt($string, false);

            return $decrypted;
        } catch (DecryptException $e) {
            // Handle the error if the payload was tampered with or the key is wrong
            abort(404);
        }
    }
}
