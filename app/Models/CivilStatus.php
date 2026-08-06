<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CivilStatus whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class CivilStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
