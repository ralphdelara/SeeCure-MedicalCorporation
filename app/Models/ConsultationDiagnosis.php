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
 * @property string $diagnosis
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read Collection<string, ConsultationDiagnosisIcd10Code> $icd10Codes
 * @property-read User|null $lastModifiedBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereUpdatedAt($value)
 *
 * @property string $consultation_id
 * @property-read int|null $icd10_codes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConsultationDiagnosis whereConsultationId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'diagnosis',
    'created_by',
    'last_modified_by',
])]
class ConsultationDiagnosis extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'consultation_diagnosis';

    protected function casts(): array
    {
        return [
            'diagnosis' => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function icd10Codes(): HasMany
    {
        return $this->hasMany(ConsultationDiagnosisIcd10Code::class);
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
