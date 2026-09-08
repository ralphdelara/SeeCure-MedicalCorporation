<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $visit_id
 * @property int $priority_type_id
 * @property-read \App\Models\PriorityType $priorityType
 * @property-read \App\Models\Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType wherePriorityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisitPriorityType whereVisitId($value)
 * @mixin \Eloquent
 */
class VisitPriorityType extends Model
{
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function priorityType(): BelongsTo
    {
        return $this->belongsTo(PriorityType::class, 'priority_type_id', 'id');
    }
}
