<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingType whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class BillingType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
