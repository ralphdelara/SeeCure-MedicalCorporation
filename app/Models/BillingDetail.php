<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $billing_id
 * @property int $billing_type_id
 * @property string $name
 * @property numeric|null $price
 * @property numeric|null $discount
 * @property numeric|null $tax
 * @property numeric|null $nett_price
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Billing|null $billing
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read BillingType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereBillingTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereUpdatedAt($value)
 * @property int|null $discount_type_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereDiscountTypeId($value)
 * @property numeric|null $tax_percent
 * @property numeric|null $tax_amount
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTaxPercent($value)
 * @property numeric|null $cost_price
 * @property int $quantity
 * @property numeric|null $total_price
 * @property int $order_no
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingDetail whereTotalPrice($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'billing_id',
    'billing_supplies_id',
    'billing_type_id',
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
class BillingDetail extends Model
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

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function supply(): BelongsTo
    {
        return $this->belongsTo(BillingSupplies::class, 'billing_supplies_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(BillingType::class, 'billing_type_id', 'id');
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
