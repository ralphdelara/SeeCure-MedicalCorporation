<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientStatus whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class PatientStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
