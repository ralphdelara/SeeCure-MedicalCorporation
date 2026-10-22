<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property int $inventory_category_id
 * @property int $inventory_unit_id
 * @property numeric $stock
 * @property numeric $cost_price
 * @property numeric $markup_amount
 * @property numeric $markup_percent
 * @property numeric $vat_percent
 * @property numeric $vat_amount
 * @property numeric $selling_price_vat_exclusive
 * @property numeric $selling_price_vat_inclusive
 * @property string|null $photo
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read InventoryCategory $category
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read InventoryUnit $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereMarkupAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereMarkupPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereInventoryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereInventoryUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereSellingPriceVatExclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereSellingPriceVatInclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inventory whereVatPercent($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InventoryAudit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InventoryStockMovement> $stockMovement
 * @property-read int|null $stock_movement_count
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'inventory_category_id',
    'inventory_unit_id',
    'stock',
    'cost_price',
    'markup_amount',
    'markup_percent',
    'vat_percent',
    'vat_amount',
    'selling_price_vat_exclusive',
    'selling_price_vat_inclusive',
    'photo',
    'status',
    'created_by',
    'last_modified_by',
])]
class Inventory extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'inventory';

    protected function casts(): array
    {
        return [
            'created_at'              => 'date:M d, Y h:i a',
            'updated_at'              => 'date:M d, Y h:i a',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(InventoryUnit::class, 'inventory_unit_id', 'id');
    }

    public function stockMovement(): HasMany
    {
        return $this->hasMany(InventoryStockMovement::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(InventoryAudit::class);
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
