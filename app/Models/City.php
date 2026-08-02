<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'city',
    'province_id',
])]
class City extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'city' => 'encrypted',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
