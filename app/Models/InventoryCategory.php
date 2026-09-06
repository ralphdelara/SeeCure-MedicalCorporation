<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryCategory whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class InventoryCategory extends Model
{
    public $timestamps = false;
}
