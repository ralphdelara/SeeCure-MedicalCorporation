<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $name
 * @property int $product_category_id
 * @property int $product_unit_id
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
 * @property-read ProductCategory $category
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read ProductUnit $unit
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMarkupAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMarkupPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPriceVatExclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPriceVatInclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVatPercent($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'product_category_id',
    'product_unit_id',
    'stock',
    'cost_price',
    'markup_amount',
    'markup_percent',
    'vat_percent',
    'vat_amount',
    'selling_price_vat_exclusive',
    'selling_price_vat_inclusive',
    'photo',
    'created_by',
    'last_modified_by',
])]
class Product extends Model
{
    use HasUuids;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'id');
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
