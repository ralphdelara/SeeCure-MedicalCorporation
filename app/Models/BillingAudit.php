<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $billing_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read AuditType $auditType
 * @property-read Billing $billing
 * @property-read User $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingAudit whereId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'billing_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class BillingAudit extends Model
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

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
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
