<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'patient_id',
    'consultation_id',
    'laboratory_id',
    'radiology_id',
    'document_type_id',
    'created_by',
    'last_modified_by',
])]
class Document extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d, Y h:i:s a',
            'updated_at' => 'date:M d, Y h:i:s a',
        ];
    }

    // --- Relationship Links ---

    public function type(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id', 'id');
    }

    public function radiology(): BelongsTo
    {
        return $this->belongsTo(Radiology::class, 'radiology_id', 'id');
    }

    // --- Child Specialized Sub-Tables ---

    public function medicalCertificate(): HasOne
    {
        return $this->hasOne(MedicalCertificate::class);
    }

    public function referralLetter(): HasOne
    {
        return $this->hasOne(ReferralLetter::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(DocumentFile::class);
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
