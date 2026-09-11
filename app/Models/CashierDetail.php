<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'cashier_id',
    'cashier_type_id',
    'name',
    'cost_price',
    'quantity',
    'total_price',
    'discount',
    'discount_type_id',
    'tax_percent',
    'tax_amount',
    'nett_price',
    'created_by',
    'last_modified_by',
])]
class CashierDetail extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'name'       => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class, 'cashier_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CashierType::class, 'cashier_type_id', 'id');
    }

    public function discountType(): BelongsTo
    {
        return $this->belongsTo(DiscountType::class, 'discount_type_id', 'id');
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
