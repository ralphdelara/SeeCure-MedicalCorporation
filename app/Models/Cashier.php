<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Guarded blocks specified fields from being added/updated via ::create and ::update
/**
 * @property string $id
 * @property string $patient_id
 * @property string $visit_id
 * @property string $billing_id
 * @property numeric|null $total_cost_price
 * @property numeric|null $total_price
 * @property numeric|null $total_discount
 * @property numeric|null $total_tax
 * @property numeric|null $total_nett_price
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, CashierAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Billing $billing
 * @property-read User $createdBy
 * @property-read Collection<int, CashierDetail> $details
 * @property-read int|null $details_count
 * @property-read User|null $lastModifiedBy
 * @property-read Patient $patient
 * @property-read Payment|null $payment
 * @property-read Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier whereVisitId($value)
 * @property string|null $pharmacy_id
 * @property-read \App\Models\Pharmacy|null $pharmacy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cashier wherePharmacyId($value)
 * @mixin \Eloquent
 */
#[Guarded([
    'id',
])]
#[Fillable([
    'patient_id',
    'visit_id',
    'billing_id',
    'pharmacy_id',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Cashier extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'cashier';

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(CashierAudit::class);
    }
}
