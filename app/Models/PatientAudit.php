<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $patient_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property string $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read Patient|null $patient
 * @property-read AuditType|null $type
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAudit whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'audit_type_id',
    'action',
    'created_by',
])]
class PatientAudit extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'patient_id' => 'encrypted',
            'action'     => 'encrypted:array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AuditType::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
