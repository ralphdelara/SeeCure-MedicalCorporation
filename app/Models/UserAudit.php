<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $user_id
 * @property int $audit_type_id
 * @property array<array-key, mixed> $action
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read AuditType|null $type
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAudit whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'audit_type_id',
    'action',
    'created_by',
])]
class UserAudit extends Model
{
    use HasUuids;

    protected function casts(): array
    {
        return [
            'action' => 'encrypted:array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AuditType::class);
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
