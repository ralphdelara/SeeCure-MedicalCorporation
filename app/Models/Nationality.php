<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'nationality',
])]
class Nationality extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'nationality' => 'encrypted',
        ];
    }
}
