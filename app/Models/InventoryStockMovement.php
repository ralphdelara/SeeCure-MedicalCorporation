<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'inventory_id',
    'stock_movement_type_id',
    'cost_price',
    'quantity',
    'current_stock',
    'new_stock',
    'total_price',
    'lot_no',
    'manufacture_date',
    'expiry_date',
    'supplier',
    'reference_no',
    'created_by',
    'last_modified_by',
])]
class InventoryStockMovement extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'manufacture_date' => 'date:M d, Y',
            'expiry_date'      => 'date:M d, Y',
            'created_at'       => 'date:M d, Y h:i a',
            'updated_at'       => 'date:M d, Y h:i a',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function stockMovementType(): BelongsTo
    {
        return $this->belongsTo(StockMovementType::class, 'stock_movement_type_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }
}
