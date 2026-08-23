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
 * @property int $laboratory_test_type_id
 * @property string $data
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereLaboratoryTestTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LaboratoryTest whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'laboratory_id',
    'laboratory_test_type_id',
    'data',
    'created_by',
    'last_modified_by',
])]
class LaboratoryTest extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'data' => 'encrypted',
        ];
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
