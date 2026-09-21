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
 * @property string $visit_id
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property string|null $performed_by
 * @property CarbonImmutable|null $date_performed
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read User|null $performedBy
 * @property-read Collection<int, LaboratoryRemark> $remarks
 * @property-read int|null $remarks_count
 * @property-read Collection<int, LaboratoryTestData> $testData
 * @property-read int|null $test_data_count
 * @property-read Collection<int, LaboratoryTestFieldData> $testFieldData
 * @property-read int|null $test_field_data_count
 * @property-read Visit $visit
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereDatePerformed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereVisitId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'performed_by',
    'date_performed',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Laboratory extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'laboratory';

    protected function casts(): array
    {
        return [
            'created_at'     => 'date:M d, Y h:i a',
            'updated_at'     => 'date:M d, Y h:i a',
            'date_performed' => 'date:M d, Y',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function remarks(): HasMany
    {
        return $this->hasMany(LaboratoryRemark::class);
    }

    public function testData(): HasMany
    {
        return $this->hasMany(LaboratoryTestData::class);
    }

    public function testFieldData(): HasMany
    {
        return $this->hasMany(LaboratoryTestFieldData::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
