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

/**
 * @property int $id
 * @property string|null $visit_id
 * @property numeric|null $total_price
 * @property numeric|null $total_discount
 * @property numeric|null $total_tax
 * @property numeric|null $total_nett_price
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, BillingAudit> $audits
 * @property-read int|null $audits_count
 * @property-read User $createdBy
 * @property-read Collection<int, BillingDetail> $details
 * @property-read int|null $details_count
 * @property-read User|null $lastModifiedBy
 * @property-read Visit|null $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalNettPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereVisitId($value)
 * @property string $patient_id
 * @property bool $is_completed
 * @property-read Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePatientId($value)
 * @property-read Cashier|null $cashier
 * @property string $transaction_header
 * @property int $transaction_no
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereControlHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereControlNo($value)
 * @property numeric|null $total_cost_price
 * @property numeric|null $total_quantity
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTotalQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTransactionHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereTransactionNo($value)
 * @mixin \Eloquent
 */
// Guarded blocks specified fields from being added/updated via ::create and ::update
#[Guarded([
    'id',
])]
#[Fillable([
    'visit_id',
    'total_cost_price',
    'total_quantity',
    'total_price',
    'total_discount',
    'total_tax',
    'total_nett_price',
    'is_completed',
    'transaction_header',
    'created_by',
    'last_modified_by',
])]
class Billing extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'billing';

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

    public function cashier(): HasOne
    {
        return $this->hasOne(Cashier::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(BillingDetail::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(BillingAudit::class);
    }
}
