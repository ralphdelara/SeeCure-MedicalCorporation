<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'profession',
    'prefix',
    'suffix',
])]
class Profession extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'profession' => 'encrypted',
            'prefix'     => 'encrypted',
            'suffix'     => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserProfession::class);
    }
}
