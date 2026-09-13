<?php

namespace App\Events;

use App\Models\InventoryStockMovement;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryStockMovementSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public InventoryStockMovement $stockMovement,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
