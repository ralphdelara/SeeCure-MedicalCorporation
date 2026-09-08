<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $laboratory_test_id
 * @property string $name
 * @property string|null $unit
 * @property string|null $field_type
 * @property numeric|null $normal_range_both_min
 * @property numeric|null $normal_range_both_max
 * @property numeric|null $normal_range_male_min
 * @property numeric|null $normal_range_male_max
 * @property numeric|null $normal_range_female_min
 * @property numeric|null $normal_range_female_max
 * @property int $sort_order
 * @property-read \App\Models\LaboratoryTest $laboratoryTest
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereLaboratoryTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeBothMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeBothMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeFemaleMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeFemaleMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeMaleMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereNormalRangeMaleMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereUnit($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_test_id',
    'name',
    'unit',
    'field_type',
    'normal_range_both_min',
    'normal_range_both_max',
    'normal_range_male_min',
    'normal_range_male_max',
    'normal_range_female_min',
    'normal_range_female_max',
    'sort_order',
])]
class LaboratoryTestField extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function laboratoryTest(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id', 'id');
    }
}
