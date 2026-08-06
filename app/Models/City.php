<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $province_id
 * @property-read Collection<int, Barangay> $barangays
 * @property-read int|null $barangays_count
 * @property-read Province $province
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereProvinceId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'province_id',
])]
class City extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function barangays(): HasMany
    {
        return $this->hasMany(Barangay::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
