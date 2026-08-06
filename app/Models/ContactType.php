<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactType query()
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class ContactType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
