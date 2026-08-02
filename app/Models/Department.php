<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'department',
])]
class Department extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'department' => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserDepartment::class);
    }
}
