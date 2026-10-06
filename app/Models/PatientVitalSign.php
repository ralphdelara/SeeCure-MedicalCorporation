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
 * @property string $patient_id
 * @property string|null $consultation_id
 * @property int $vital_sign_id
 * @property int $vital_sign_field_id
 * @property numeric $value
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read VitalSign $vitalSign
 * @property-read VitalSignField $vitalSignField
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientVitalSign whereVitalSignId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'consultation_id',
    'vital_sign_id',
    'vital_sign_field_id',
    'value',
    'created_by',
    'last_modified_by',
])]
class PatientVitalSign extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d, Y h:i:s a',
            'updated_at' => 'date:M d, Y h:i:s a',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function vitalSign(): BelongsTo
    {
        return $this->belongsTo(VitalSign::class, 'vital_sign_id', 'id');
    }

    public function vitalSignField(): BelongsTo
    {
        return $this->belongsTo(VitalSignField::class, 'vital_sign_field_id', 'id');
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
