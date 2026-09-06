<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryUnit whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class InventoryUnit extends Model
{
    public $timestamps = false;
}
