<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $laboratory_id
 * @property string $laboratory_test_data_id
 * @property int $laboratory_field_id
 * @property string|null $value
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read LaboratoryTestField $field
 * @property-read Laboratory $laboratory
 * @property-read User|null $lastModifiedBy
 * @property-read LaboratoryTestData $testData
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryTestDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryTestFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereLaboratoryFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestFieldData whereOrderNo($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_id',
    'laboratory_test_data_id',
    'laboratory_field_id',
    'value',
    'created_by',
    'last_modified_by',
])]
class LaboratoryTestFieldData extends Model
{
    use CorrectTimezone;

    public $table = 'laboratory_test_field_data';

    protected function casts(): array
    {
        return [
            'value'      => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }

    public function testData(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTestData::class, 'laboratory_test_data_id', 'id');
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(LaboratoryField::class, 'laboratory_field_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }
}
