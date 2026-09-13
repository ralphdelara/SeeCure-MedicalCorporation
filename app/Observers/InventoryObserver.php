<?php

namespace App\Observers;

use App\Events\InventorySaved;
use App\Models\Inventory;

class InventoryObserver
{
    /**
     * Handle the Inventory "created" event.
     */
    public function created(Inventory $inventory): void
    {
        InventorySaved::dispatch($inventory, 'created');
    }

    /**
     * Handle the Inventory "updated" event.
     */
    public function updated(Inventory $inventory): void
    {
        if (! $inventory->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $inventory->getChanges();
        $originalFields = $inventory->getOriginal();

        InventorySaved::dispatch($inventory, 'updated', $changedFields, $originalFields);
    }
}
