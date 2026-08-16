<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'consultation_id',
    'icd10_code_id',
    'created_by',
    'last_modified_by',
])]
class ConsultationDiagnosis extends Model
{
    use HasUuids, CorrectTimezone;

    public $table = 'consultation_diagnosis';

    protected function casts(): array
    {
        return [
            'diagnosis' => 'encrypted',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function icd10Codes(): BelongsTo
    {
        return $this->belongsTo(ConsultationDiagnosisIcd10Code::class, 'consultation_id', 'id');
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
