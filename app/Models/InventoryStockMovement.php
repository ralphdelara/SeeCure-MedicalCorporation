<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $inventory_id
 * @property int $stock_movement_type_id
 * @property numeric $cost_price
 * @property numeric $current_stock
 * @property numeric $quantity
 * @property numeric $new_stock
 * @property numeric $total_price
 * @property string $lot_no
 * @property \Carbon\CarbonImmutable $manufacture_date
 * @property \Carbon\CarbonImmutable $expiry_date
 * @property string|null $supplier
 * @property string|null $reference_no
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Inventory $inventory
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\StockMovementType $stockMovementType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereCurrentStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereLotNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereManufactureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereNewStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereReferenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereStockMovementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryStockMovement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
