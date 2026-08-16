<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'laboratory_id',
    'laboratory_test_type_id',
    'data',
    'created_by',
    'last_modified_by',
])]
class LaboratoryTest extends Model
{
    use HasUuids, CorrectTimezone;

    protected function casts(): array
    {
        return [
            'data' => 'encrypted',
        ];
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
