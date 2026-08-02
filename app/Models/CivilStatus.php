<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'civil_status',
])]
class CivilStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'civil_status' => 'encrypted',
        ];
    }
}
