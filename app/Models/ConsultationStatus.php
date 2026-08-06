<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationStatus whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class ConsultationStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
