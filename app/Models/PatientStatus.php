<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'status',
])]
class PatientStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'status' => 'encrypted',
        ];
    }
}
