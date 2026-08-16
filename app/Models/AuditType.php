<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditType whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class AuditType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name'   => 'encrypted',
        ];
    }
}
