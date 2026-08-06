<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $consultation_id
 * @property int $type_id
 * @property-read Consultation $consultation
 * @property-read ConsultationType $type
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDetailType whereTypeId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'type_id',
])]
class ConsultationDetailType extends Model
{
    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ConsultationType::class);
    }
}
