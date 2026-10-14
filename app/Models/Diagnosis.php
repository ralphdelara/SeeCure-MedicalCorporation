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
 * @property-read Collection<string, DiagnosisIcd10Code> $icd10Codes
 * @property-read User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereUpdatedAt($value)
 * @property string $consultation_id
 * @property-read int|null $icd10_codes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Diagnosis whereConsultationId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'diagnosis',
    'created_by',
    'last_modified_by',
    'created_at', //added temporary for migration
    'updated_at', //added temporary for migration
])]
class Diagnosis extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'diagnosis';

    protected function casts(): array
    {
        return [
            'diagnosis'  => 'encrypted',
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
        return $this->hasMany(DiagnosisIcd10Code::class);
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
