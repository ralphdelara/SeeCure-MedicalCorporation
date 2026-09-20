<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $laboratory_test_id
 * @property int $laboratory_field_id
 * @property-read \App\Models\LaboratoryField $field
 * @property-read \App\Models\LaboratoryTest $test
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereLaboratoryFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestField whereLaboratoryTestId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_test_id',
    'laboratory_field_id',
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

    public function test(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id', 'id');
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(LaboratoryField::class, 'laboratory_field_id', 'id');
    }
}
