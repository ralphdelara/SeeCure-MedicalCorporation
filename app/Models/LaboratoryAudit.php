<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $laboratory_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Laboratory $laboratory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryAudit whereLaboratoryId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class LaboratoryAudit extends Model
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

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
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
