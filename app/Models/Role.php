<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'role',
])]
class Role extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'role' => 'encrypted',
        ];
    }
}
