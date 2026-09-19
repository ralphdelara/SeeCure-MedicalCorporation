<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $patient_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class PatientAudit extends Model
{
    use CorrectTimezone;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'data'       => 'encrypted',
            'created_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function auditType(): BelongsTo
    {
        return $this->belongsTo(AuditType::class, 'audit_type_id', 'id');
    }
}
