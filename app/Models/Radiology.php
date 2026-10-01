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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology query()
 * @property string $id
 * @property string $visit_id
 * @property string $patient_id
 * @property string $consultation_id
 * @property bool $is_completed
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Radiology whereVisitId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'is_completed',
    'created_by',
    'last_modified_by',
])]
class Radiology extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'radiology';
}
