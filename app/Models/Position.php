<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class Position extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
