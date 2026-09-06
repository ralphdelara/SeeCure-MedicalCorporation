<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PriorityType whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class PriorityType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
