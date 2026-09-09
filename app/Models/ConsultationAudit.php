<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $consultation_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read AuditType $auditType
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationAudit whereId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class ConsultationAudit extends Model
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

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
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
