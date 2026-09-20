<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $pharmacy_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Pharmacy $pharmacy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyAudit wherePharmacyId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'pharmacy_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class PharmacyAudit extends Model
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

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
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
