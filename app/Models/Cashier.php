<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Guarded blocks specified fields from being added/updated via ::create and ::update
#[Guarded([
    'id',
])]
#[Fillable([
    'patient_id',
    'visit_id',
    'billing_id',
    'total_cost_price',
    'total_price',
    'total_discount',
    'total_tax',
    'total_nett_price',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Cashier extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'cashier';

    protected function casts(): array
    {
        return [
            'created_at'              => 'date:M d, Y h:i a',
            'updated_at'              => 'date:M d, Y h:i a',
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

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(CashierDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(CashierAudit::class);
    }
}
