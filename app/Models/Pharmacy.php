<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $patient_id
 * @property string $visit_id
 * @property string $consultation_id
 * @property string $billing_id
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Billing $billing
 * @property-read \App\Models\Consultation $consultation
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PharmacyDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Visit $visit
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
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'visit_id',
    'consultation_id',
    'billing_id',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Pharmacy extends Model
{
    use HasUuids, CorrectTimezone;

    public $table = 'pharmacy';

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d Y, h:i:s a',
            'updated_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PharmacyDetail::class);
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
