<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property Carbon|null $date_of_birth
 * @property string|null $age
 * @property string|null $contact_number1
 * @property string|null $contact_number2
 * @property string|null $email
 * @property string|null $occupation
 * @property string|null $philhealth_id
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property int|null $gender_id
 * @property int|null $civil_status_id
 * @property int|null $nationality_id
 * @property int $status_id
 * @property int|null $patient_suffix_id
 * @property int $created_by
 * @property string|null $photo
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, PatientAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read CivilStatus|null $civilStatus
 * @property-read User|null $createdBy
 * @property-read Gender|null $gender
 * @property-read Collection<int, PatientGuardian> $guardian
 * @property-read int|null $guardian_count
 * @property-read Nationality|null $nationality
 * @property-read Collection<int, PatientVitalSign> $patientVitalSigns
 * @property-read int|null $patient_vital_signs_count
 * @property-read Province|null $province
 * @property-read PatientStatus $status
 * @property-read PatientSuffix|null $suffix
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCivilStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereNationalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePatientSuffixId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhilhealthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'last_name',
    'first_name',
    'middle_name',
    'date_of_birth',
    'age',
    'contact_number1',
    'contact_number2',
    'email',
    'occupation',
    'philhealth_id',

    'house_no',
    'street',
    'barangay_id',
    'city_id',
    'province_id',

    'photo',

    'gender_id',
    'civil_status_id',
    'nationality_id',
    'status_id',
    'patient_suffix_id',
    'created_by',
    'last_modified_by',
])]
class Patient extends Model
{
    protected $appends = ['full_name'];

    protected function casts(): array
    {
        return [
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->last_name.', '.$this->first_name.($this->middle_name ? ' '.$this->middle_name : '');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function suffix(): BelongsTo
    {
        return $this->belongsTo(PatientSuffix::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PatientStatus::class);
    }

    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }

    public function guardian(): HasMany
    {
        return $this->hasMany(PatientGuardian::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function audits(): HasMany
    {
        return $this->hasMany(PatientAudit::class);
    }

    public function patientVitalSigns(): HasMany
    {
        return $this->hasMany(PatientVitalSign::class);
    }
}
