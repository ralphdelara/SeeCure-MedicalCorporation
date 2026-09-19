<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $pharmacy_id
 * @property string $prescription_id
 * @property string $prescription_quantity
 * @property string $pharmacy_quantity
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePharmacyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails wherePrescriptionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereDiscountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereTaxPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetails whereTotalPrice($value)
 * @mixin \Eloquent
 */
class PharmacyDetails extends Model
{
    //
}
