<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
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
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BillingAudit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BillingDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Visit|null $visit
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
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePatientId($value)
 * @mixin \Eloquent
 */
// Guarded blocks specified fields from being added/updated via ::create and ::update
#[Guarded([
    'id',
])]
#[Fillable([
    'patient_id',
    'visit_id',
    'total_price',
    'total_discount',
    'total_tax',
    'total_nett_price',
    'is_completed',
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
            'created_at'              => 'date:M d, Y h:i a',
            'updated_at'              => 'date:M d, Y h:i a',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
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
