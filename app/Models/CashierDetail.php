<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $cashier_id
 * @property int $cashier_type_id
 * @property string $name
 * @property numeric|null $cost_price
 * @property int $quantity
 * @property numeric|null $total_price
 * @property numeric|null $discount
 * @property int|null $discount_type_id
 * @property numeric|null $tax_percent
 * @property numeric|null $tax_amount
 * @property numeric|null $nett_price
 * @property int $order
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\DiscountType|null $discountType
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\CashierType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCashierTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereDiscountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'cashier_id',
    'cashier_type_id',
    'name',
    'cost_price',
    'quantity',
    'total_price',
    'discount',
    'discount_type_id',
    'tax_percent',
    'tax_amount',
    'nett_price',
    'created_by',
    'last_modified_by',
])]
class CashierDetail extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'name'       => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CashierType::class, 'cashier_type_id', 'id');
    }

    public function discountType(): BelongsTo
    {
        return $this->belongsTo(DiscountType::class, 'discount_type_id', 'id');
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
