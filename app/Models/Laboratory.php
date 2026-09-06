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
 * @property string $visit_id
 * @property string $patient_id
 * @property string|null $consultation_id
 * @property int $status_id
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation|null $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @property-read Patient|null $patient
 * @property-read Collection<int, LaboratoryTest> $tests
 * @property-read int|null $tests_count
 * @property-read Visit $visit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Laboratory whereVisitId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'visit_id',
    'patient_id',
    'consultation_id',
    'created_by',
    'last_modified_by',
])]
class Laboratory extends Model
{
    use CorrectTimezone, HasUuids;

    public $table = 'laboratory';

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(LaboratoryTest::class);
    }
}
