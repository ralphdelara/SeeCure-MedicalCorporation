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
 * @property string $consultation_id
 * @property string $diagnosis_id
 * @property string|null $icd10_code_id
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read Consultation $consultation
 * @property-read Diagnosis $diagnosis
 * @property-read User $createdBy
 * @property-read Icd10Code|null $icd10
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereDiagnosisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereIcdCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereId($value)
 * @property-read Icd10Code|null $icd10Code
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiagnosisIcd10Code whereIcd10CodeId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'diagnosis_id',
    'icd10_code_id',
])]
class DiagnosisIcd10Code extends Model
{
    use CorrectTimezone, HasUuids;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'icd10_code_id' => 'encrypted',
        ];
    }

    public function diagnosis(): BelongsTo
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosis_id', 'id');
    }

    public function icd10Code(): BelongsTo
    {
        return $this->belongsTo(Icd10Code::class, 'icd10_code_id', 'id');
    }
}
