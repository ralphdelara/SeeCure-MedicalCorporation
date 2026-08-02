<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'gender',
])]
class Gender extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'gender' => 'encrypted',
        ];
    }
}
