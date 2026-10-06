<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $user_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereUserId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class UserAudit extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
