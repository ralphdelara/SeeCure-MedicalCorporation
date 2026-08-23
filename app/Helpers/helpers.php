<?php

use Illuminate\Database\Eloquent\Model;

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
    function computeExactAge(?string $dateOfBirth): ?string
    {
        if (empty($dateOfBirth)) {
            return null;
        }

        $dob = new DateTime($dateOfBirth);
        $currentDate = new DateTime;

        $diff = $dob->diff($currentDate);

        return $diff->format('%yy %mm %dd');
    }
}
