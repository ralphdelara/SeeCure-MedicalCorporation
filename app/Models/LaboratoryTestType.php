<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestType whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class LaboratoryTestType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
