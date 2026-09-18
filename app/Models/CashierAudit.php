<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $cashier_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierAudit whereId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'cashier_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class CashierAudit extends Model
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

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'id');
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
