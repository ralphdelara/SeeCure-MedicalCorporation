<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $patient_id
 * @property bool $has_consultation
 * @property bool $has_laboratory
 * @property bool $has_radiology
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User|null $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasLaboratory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereHasRadiology($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereUpdatedAt($value)
 * @property bool $consultation_completed
 * @property bool $lab_completed
 * @property bool $radiology_completed
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereConsultationCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereLabCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereRadiologyCompleted($value)
 * @property string|null $admitted_at
 * @property string|null $discharged_at
 * @property bool $is_emergency
 * @property int $visit_status_id
 * @property-read \App\Models\VisitStatus $visitStatus
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereDischargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereIsEmergency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit wherePriorityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereVisitStatusId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PriorityType> $priorityTypes
 * @property-read int|null $priority_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Laboratory> $laboratory
 * @property-read int|null $laboratory_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Radiology> $radiology
 * @property-read int|null $radiology_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Billing> $billing
 * @property-read int|null $billing_count
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'admitted_at',
    'discharged_at',
    'has_consultation',
    'has_laboratory',
    'has_radiology',
    'is_emergency',
    'visit_status_id',
    'created_by',
    'last_modified_by',
])]
class Visit extends Model
{
    use CorrectTimezone, HasUuids;

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lastModifiedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function priorityTypes(): BelongsToMany
    {
        return $this->belongsToMany(PriorityType::class, 'visit_priority_types', 'visit_id', 'priority_type_id');
    }

    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class);
    }

    public function radiology(): HasMany
    {
        return $this->hasMany(Radiology::class);
    }

    public function laboratory(): HasMany
    {
        return $this->hasMany(Laboratory::class);
    }

    public function billing(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function cashier(): HasMany
    {
        return $this->hasMany(Cashier::class);
    }

    public function visitStatus(): BelongsTo
    {
        return $this->belongsTo(VisitStatus::class, 'visit_status_id', 'id');
    }
}
