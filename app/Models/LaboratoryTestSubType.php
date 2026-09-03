<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $laboratory_test_type_id
 * @property string $name
 * @property numeric $price
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereLaboratoryTestTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTestSubType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class LaboratoryTestSubType extends Model
{
    //
}
