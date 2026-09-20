<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $patient_id
 * @property string $visit_id
 * @property string $consultation_id
 * @property string $billing_id
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Billing $billing
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @property-read Collection<int, PharmacyDetail> $details
 * @property-read int|null $details_count
 * @property-read User|null $lastModifiedBy
 * @property-read Patient $patient
 * @property-read Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereVisitId($value)
 * @property numeric|null $total_cost_price
 * @property numeric $total_quantity
 * @property numeric|null $total_price
 * @property numeric|null $total_discount
 * @property numeric|null $total_tax
 * @property numeric|null $total_nett_price
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pharmacy whereTransactionNo($value)
 * @property-read \App\Models\PharmacyPickList|null $pickList
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'total_cost_price',
    'total_quantity',
    'total_price',
    'total_discount',
    'total_tax',
    'total_nett_price',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Pharmacy extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'pharmacy';

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d Y, h:i:s a',
            'updated_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PharmacyDetail::class);
    }

    public function pickList(): HasOne
    {
        return $this->hasOne(PharmacyPickList::class);
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
