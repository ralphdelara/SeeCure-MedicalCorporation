<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $laboratory_package_id
 * @property int $laboratory_test_id
 * @property-read \App\Models\LaboratoryPackage $package
 * @property-read \App\Models\LaboratoryTest $test
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest whereLaboratoryPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackageTest whereLaboratoryTestId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_package_id',
    'laboratory_test_id',
])]
class LaboratoryPackageTest extends Model
{
    public $timestamps = false;

    public function package(): BelongsTo
    {
        return $this->belongsTo(LaboratoryPackage::class, 'laboratory_package_id', 'id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id', 'id');
    }
}
