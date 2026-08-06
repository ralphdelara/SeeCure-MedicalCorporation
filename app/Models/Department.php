<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, UserDepartment> $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class Department extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserDepartment::class);
    }
}
