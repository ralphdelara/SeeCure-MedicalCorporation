<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Relationship whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class Relationship extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
