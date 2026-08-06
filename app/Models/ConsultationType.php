<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection<int, Consultation> $consultations
 * @property-read int|null $consultations_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationType whereName($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class ConsultationType extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
}
