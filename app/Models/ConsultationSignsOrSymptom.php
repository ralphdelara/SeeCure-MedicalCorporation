<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $consultation_id
 * @property int $signs_or_symptom_id
 * @property-read Consultation $consultation
 * @property-read SignsOrSymptom $signsOrSymptom
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationSignsOrSymptom whereSignsOrSymptomId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'signs_or_symptom_id',
])]
class ConsultationSignsOrSymptom extends Model
{
    public $timestamps = false;

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function signsOrSymptom(): BelongsTo
    {
        return $this->belongsTo(SignsOrSymptom::class);
    }
}
