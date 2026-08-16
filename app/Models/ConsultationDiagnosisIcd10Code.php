<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'consultation_id',
    'consultation_diagnosis_id',
    'icd10_code_id',
    'created_by',
])]
class ConsultationDiagnosisIcd10Code extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'icd10_code_id' => 'encrypted',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function consultationDiagnosis(): BelongsTo
    {
        return $this->belongsTo(ConsultationDiagnosis::class, 'consultation_diagnosis_id', 'id');
    }

    public function icd10(): BelongsTo
    {
        return $this->belongsTo(Icd10Code::class, 'icd10_code_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
