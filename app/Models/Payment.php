<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Guarded blocks specified fields from being added/updated via ::create and ::update
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
