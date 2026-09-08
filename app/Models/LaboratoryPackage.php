<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LaboratoryTest> $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryPackage wherePrice($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'price',
])]
class LaboratoryPackage extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(LaboratoryTest::class, 'laboratory_package_tests', 'laboratory_package_id', 'laboratory_test_id');
    }
}
