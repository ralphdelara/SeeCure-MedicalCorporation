<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Guarded blocks specified fields from being added/updated via ::create and ::update
/**
 * @property string $id
 * @property string $receipt_sequence_header
 * @property int $receipt_sequence
 * @property string $patient_id
 * @property string $visit_id
 * @property string $cashier_id
 * @property int|null $payment_method_id
 * @property int $payment_status_id
 * @property string|null $reference_number
 * @property numeric|null $total_amount
 * @property numeric|null $amount_received
 * @property numeric|null $amount_paid
 * @property numeric|null $amount_change
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cashier $cashier
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\PaymentMethod|null $method
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\PaymentStatus $status
 * @property-read \App\Models\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReceiptSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReceiptSequenceHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereVisitId($value)
 * @mixin \Eloquent
 */
#[Guarded([
    'id',
    'receipt_number',
])]
#[Fillable([
    'patient_id',
    'visit_id',
    'cashier_id',
    'receipt_sequence_header',
    'payment_method_id',
    'payment_status_id',
    'reference_number',
    'total_amount',
    'amount_received',
    'amount_paid',
    'amount_change',
    'created_by',
    'last_modified_by',
])]
class Payment extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'reference_number' => 'encrypted',
            'created_at'       => 'date:M d, Y h:i a',
            'updated_at'       => 'date:M d, Y h:i a',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'id');
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id', 'id');
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
