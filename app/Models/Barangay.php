<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $province_id
 * @property-read City $city
 * @property-read Province $province
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereProvinceId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'city_id',
    'province_id',
])]
class Barangay extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
