<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'position',
])]
class Position extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'position' => 'encrypted',
        ];
    }
}
