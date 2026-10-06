<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $patient_id
 * @property string|null $consultation_id
 * @property string|null $laboratory_id
 * @property string|null $radiology_id
 * @property int $document_type_id
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Consultation|null $consultation
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DocumentFile> $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Laboratory|null $laboratory
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\MedicalCertificate|null $medicalCertificate
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Radiology|null $radiology
 * @property-read \App\Models\ReferralLetter|null $referralLetter
 * @property-read \App\Models\DocumentType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereDocumentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereLaboratoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereRadiologyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
