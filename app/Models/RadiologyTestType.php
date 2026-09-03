<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RadiologyTestType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RadiologyTestType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RadiologyTestType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RadiologyTestType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RadiologyTestType whereName($value)
 *
 * @mixin \Eloquent
 */
class RadiologyTestType extends Model
{
    public $timestamps = false;
}
