<?php

namespace App\Services;

use App\Models\PharmacyPickList;
use Auth;

class PrintService
{
    public function generatePickList(string $pharmacyId): array
    {
        $pickList = PharmacyPickList::firstOrCreate(
            ['pharmacy_id' => $pharmacyId], // Unique attributes to search for
            ['created_by' => Auth::id()],   // Additional attributes to set only if creating
        );

        return $pickList->toArray();
    }
}
