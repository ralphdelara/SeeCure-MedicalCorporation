<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $payment_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentAudit wherePaymentId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'payment_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class PaymentAudit extends Model
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

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'billing_id', 'id');
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
