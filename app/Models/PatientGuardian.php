<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $patient_id
 * @property string $name
 * @property string|null $contact_number
 * @property string|null $email
 * @property int $relationship_id
 * @property int $created_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $createdBy
 * @property-read Patient $patient
 * @property-read Relationship $relationship
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientGuardian whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'patient_id',
    'name',
    'contact_number',
    'email',
    'relationship_id',
    'created_by',
    'last_modified_by',
])]
class PatientGuardian extends Model
{
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class);
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
