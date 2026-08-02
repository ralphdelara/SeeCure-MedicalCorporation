<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'specialty',
    'suffix',
])]
class Specialty extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'specialty' => 'encrypted',
            'suffix' => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserSpecialty::class);
    }
}
