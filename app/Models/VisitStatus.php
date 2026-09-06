<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitStatus whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class VisitStatus extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
