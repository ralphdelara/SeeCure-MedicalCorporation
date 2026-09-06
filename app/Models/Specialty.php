<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $suffix
 * @property-read Collection<int, UserSpecialty> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialty whereSuffix($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'suffix',
])]
class Specialty extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name'   => 'encrypted',
            'suffix' => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserSpecialty::class);
    }
}
