<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $laboratory_id
 * @property int|null $laboratory_package_id
 * @property int $laboratory_type_id
 * @property int $laboratory_test_id
 * @property string|null $remarks
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read Collection<int, LaboratoryTestFieldData> $fields
 * @property-read int|null $fields_count
 * @property-read Laboratory $laboratory
 * @property-read User|null $lastModifiedBy
 * @property-read LaboratoryPackage|null $package
 * @property-read LaboratoryTest $test
 * @property-read LaboratoryType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLaboratoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_id',
    'laboratory_package_id',
    'laboratory_type_id',
    'laboratory_test_id',
    'created_by',
    'last_modified_by',
])]
class LaboratoryTestData extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'laboratory_test_data';

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(LaboratoryPackage::class, 'laboratory_package_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LaboratoryType::class, 'laboratory_type_id', 'id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id', 'id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(LaboratoryTestFieldData::class);
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
