<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'contact_type',
])]
class ContactType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'contact_type' => 'encrypted',
        ];
    }
}
