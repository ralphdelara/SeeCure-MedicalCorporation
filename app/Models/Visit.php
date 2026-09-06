<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property int $priority_type_id
 * @property int $visit_status_id
 * @property-read \App\Models\VisitStatus $visitStatus
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereDischargedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereIsEmergency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit wherePriorityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visit whereVisitStatusId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'has_consultation',
    'has_laboratory',
    'has_radiology',
    'visit_status_id',
    'is_emergency',
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

    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class);
    }

    public function visitStatus(): BelongsTo
    {
        return $this->belongsTo(VisitStatus::class, 'visit_status_id', 'id');
    }
}
