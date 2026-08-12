<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $patient_id
 * @property string|null $guardian_name
 * @property string|null $guardian_contact_number
 * @property string|null $guardian_email
 * @property int $status_id
 * @property int $doctor_id
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $createdBy
 * @property-read User $doctor
 * @property-read Patient $patient
 * @property-read Collection<int, PatientVitalSign> $patientVitalSign
 * @property-read int|null $patient_vital_sign_count
 * @property-read Collection<int, ConsultationSignsOrSymptom> $signsOrSymptoms
 * @property-read int|null $signs_or_symptoms_count
 * @property-read ConsultationStatus $status
 * @property-read Collection<int, ConsultationDetailType> $types
 * @property-read int|null $types_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'patient_id',
    'guardian_name',
    'guardian_contact_number',
    'guardian_email',
    'guardian_relationship_id',
    'signs_or_symptom_id',
    'status_id',
    'doctor_id',
    'created_by',
    'last_modified_by',
])]
class Consultation extends Model
{
    use CorrectTimezone;

    protected function casts(): array
    {
        return [
            'guardian_name'           => 'encrypted',
            'guardian_contact_number' => 'encrypted',
            'guardian_email'          => 'encrypted',
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

    public function patientVitalSign(): HasMany
    {
        return $this->hasMany(PatientVitalSign::class);
    }

    public function signsOrSymptoms(): HasMany
    {
        return $this->hasMany(ConsultationSignsOrSymptom::class);
    }

    public function types(): HasMany
    {
        return $this->hasMany(ConsultationDetailType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ConsultationStatus::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function guardianRelationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class, 'relationship_id', 'id');
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
