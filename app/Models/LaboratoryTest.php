<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property int|null $laboratory_type_id
 * @property-read Collection<int, LaboratoryTestField> $fields
 * @property-read int|null $fields_count
 * @property-read LaboratoryPackage|null $package
 * @property-read LaboratoryType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereLaboratoryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest wherePrice($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'price',
    'laboratory_type_id',
])]
class LaboratoryTest extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function package(): HasOneThrough
    {
        return $this->hasOneThrough(
            LaboratoryPackage::class,
            LaboratoryPackageTest::class,
            'laboratory_test_id',
            'id',
            'id',
            'laboratory_package_id',
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LaboratoryType::class, 'laboratory_type_id', 'id');
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(LaboratoryField::class, 'laboratory_test_fields', 'laboratory_test_id', 'laboratory_field_id');
    }
}
