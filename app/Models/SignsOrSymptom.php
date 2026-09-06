<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SignsOrSymptom whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class SignsOrSymptom extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
