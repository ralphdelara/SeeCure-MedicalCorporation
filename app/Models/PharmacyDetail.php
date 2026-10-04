<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $pharmacy_id
 * @property string $prescription_id
 * @property string $prescription_quantity
 * @property string $pharmacy_quantity
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Pharmacy $pharmacy
 * @property-read Prescription $prescription
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereUpdatedAt($value)
 *
 * @property string $name
 * @property numeric|null $cost_price
 * @property int $quantity
 * @property numeric|null $total_price
 * @property numeric|null $discount
 * @property int|null $discount_type_id
 * @property numeric|null $tax_percent
 * @property numeric|null $tax_amount
 * @property numeric|null $nett_price
 * @property int $order_no
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereDiscountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereTotalPrice($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'pharmacy_id',
    'inventory_id',
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
class PharmacyDetail extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'name'       => 'encrypted',
            'created_at' => 'date:M d Y, h:i:s a',
            'updated_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
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
