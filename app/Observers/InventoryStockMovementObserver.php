<?php

namespace App\Observers;

use App\Events\InventoryStockMovementSaved;
use App\Models\InventoryStockMovement;

class InventoryStockMovementObserver
{
    /**
     * Handle the InventoryStockMovement "created" event.
     */
    public function created(InventoryStockMovement $stockMovement): void
    {
        InventoryStockMovementSaved::dispatch($stockMovement, 'created');
    }

    /**
     * Handle the InventoryStockMovement "updated" event.
     */
    public function updated(InventoryStockMovement $stockMovement): void
    {
        if (! $stockMovement->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $stockMovement->getChanges();
        $originalFields = $stockMovement->getOriginal();

        InventoryStockMovementSaved::dispatch($stockMovement, 'updated', $changedFields, $originalFields);
    }

    public function deleting(InventoryStockMovement $stockMovement): void
    {
        InventoryStockMovementSaved::dispatch($stockMovement, 'deleted');
    }
}
