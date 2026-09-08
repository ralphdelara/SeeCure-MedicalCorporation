<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryType whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class LaboratoryType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
