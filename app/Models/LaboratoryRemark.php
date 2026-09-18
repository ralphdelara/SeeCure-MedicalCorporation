<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $laboratory_id
 * @property int|null $laboratory_package_id
 * @property int|null $laboratory_type_id
 * @property int|null $laboratory_test_id
 * @property string $remarks
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read Laboratory $laboratory
 * @property-read User|null $lastModifiedBy
 * @property-read LaboratoryPackage|null $package
 * @property-read LaboratoryTest|null $test
 * @property-read LaboratoryType|null $type
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereLaboratoryPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereLaboratoryTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereLaboratoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryRemark whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_id',
    'laboratory_type_id',
    'laboratory_test_id',
    'laboratory_field_id',
    'remarks',
    'created_by',
    'last_modified_by',
])]
class LaboratoryRemark extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'remarks' => 'encrypted',
        ];
    }

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LaboratoryType::class, 'laboratory_type_id', 'id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id', 'id');
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
