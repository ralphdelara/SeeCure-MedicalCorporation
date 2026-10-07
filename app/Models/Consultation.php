<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $visit_id
 * @property string $patient_id
 * @property string|null $guardian_name
 * @property string|null $guardian_contact_number
 * @property string|null $guardian_email
 * @property int|null $guardian_relationship_id
 * @property string|null $diagnosis
 * @property string $doctor_id
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $createdBy
 * @property-read User $doctor
 * @property-read Relationship|null $guardianRelationship
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read Collection<int, PatientVitalSign> $patientVitalSign
 * @property-read int|null $patient_vital_sign_count
 * @property-read Collection<int, ConsultationSignsOrSymptom> $signsOrSymptoms
 * @property-read int|null $signs_or_symptoms_count
 * @property-read Visit $visit
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereGuardianRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereVisitId($value)
 *
 * @property string|null $follow_up_date
 * @property-read Collection<int, ConsultationAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Collection<int, Document> $documents
 * @property-read int|null $documents_count
 * @property-read Laboratory|null $laboratory
 * @property-read Collection<int, Prescription> $prescriptions
 * @property-read int|null $prescriptions_count
 * @property-read Radiology|null $radiology
 * @property-read ConsultationSoap|null $soap
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereFollowUpDate($value)
 *
 * @property bool $is_completed
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereIsCompleted($value)
 *
 * @property string|null $consult_reason
 * @property-read int|null $laboratory_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation whereConsultReason($value)
 *
 * @property string|null $prescription_remarks
 * @property-read Collection<int, PatientVitalSign> $vitalSigns
 * @property-read int|null $vital_signs_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Consultation wherePrescriptionRemarks($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'old_consult_id',
    'prescription_remarks',
    'guardian_name',
    'guardian_contact_number',
    'guardian_email',
    'guardian_relationship_id',
    'consult_reason',
    'is_completed',
    'doctor_id',
    'created_by',
    'last_modified_by',
])]
class Consultation extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'consult_reason'          => 'encrypted',
            'prescription_remarks'    => 'encrypted',
            'guardian_name'           => 'encrypted',
            'guardian_contact_number' => 'encrypted',
            'guardian_email'          => 'encrypted',
            'created_at'              => 'date:M d, Y h:i a',
            'updated_at'              => 'date:M d, Y h:i a',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function patientVitalSign(): HasMany
    {
        return $this->hasMany(PatientVitalSign::class);
    }

    public function signsOrSymptoms(): BelongsToMany
    {
        return $this->belongsToMany(SignsOrSymptom::class, 'consultation_signs_or_symptoms', 'consultation_id', 'signs_or_symptom_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function guardianRelationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class, 'guardian_relationship_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function soap(): HasOne
    {
        return $this->hasOne(ConsultationSoap::class);
    }

    public function diagnosis(): HasOne
    {
        return $this->hasOne(Diagnosis::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function radiology(): HasOne
    {
        return $this->hasOne(Radiology::class);
    }

    public function vitalSigns(): HasMany
    {
        return $this->hasMany(PatientVitalSign::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(ConsultationAudit::class);
    }
}
