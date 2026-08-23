<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryStatus whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class LaboratoryStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
