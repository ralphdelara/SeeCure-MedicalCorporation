<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, VitalSignField> $fields
 * @property-read int|null $fields_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSign whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class VitalSign extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function fields(): HasMany
    {
        return $this->hasMany(VitalSignField::class);
    }
}
