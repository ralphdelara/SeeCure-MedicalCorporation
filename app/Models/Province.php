<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'province',
])]
class Province extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'province' => 'encrypted',
        ];
    }
}
