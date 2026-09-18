<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CashierType whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class CashierType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
