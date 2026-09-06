<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $prefix
 * @property string|null $suffix
 * @property-read Collection<int, UserProfession> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profession whereSuffix($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'prefix',
    'suffix',
])]
class Profession extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name'   => 'encrypted',
            'prefix' => 'encrypted',
            'suffix' => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserProfession::class);
    }
}
