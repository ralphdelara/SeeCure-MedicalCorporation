<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10Code whereId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'code',
    'description',
])]
class Icd10Code extends Model
{
    public $timestamps = false;
}
