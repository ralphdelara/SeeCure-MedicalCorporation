<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientSuffix whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class PatientSuffix extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
