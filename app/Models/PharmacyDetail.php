<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'pharmacy_id',
    'prescription_id',
    'prescription_quantity',
    'pharmacy_quantity',
    'created_by',
    'last_modified_by',
])]
class PharmacyDetail extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d Y, h:i:s a',
            'updated_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
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
