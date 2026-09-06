<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $unit
 * @property int $vital_sign_id
 * @property-read VitalSign $vitalSign
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VitalSignField whereVitalSignId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'unit',
    'vital_sign_id',
])]
class VitalSignField extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function vitalSign(): BelongsTo
    {
        return $this->belongsTo(VitalSign::class);
    }
}
