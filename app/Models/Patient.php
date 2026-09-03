<?php

namespace App\Models;

use App\Casts\EncryptedDate;
use App\Traits\CorrectTimezone;
use App\Traits\PersonDetails;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\Constants;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\Transformation\Lowercase;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

/**
 * @property string $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $date_of_birth
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
 * @property string|null $photo
 * @property string|null $last_name_index
 * @property string|null $first_name_index
 * @property string|null $middle_name_index
 * @property int|null $batch
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, PatientAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read CivilStatus|null $civilStatus
 * @property-read Collection<int, Consultation> $consultation
 * @property-read int|null $consultation_count
 * @property-read User $createdBy
 * @property-read Gender|null $gender
 * @property-read string $full_name
 * @property-read Collection<int, Laboratory> $laboratory
 * @property-read int|null $laboratory_count
 * @property-read User|null $lastModifiedBy
 * @property-read Nationality|null $nationality
 * @property-read Collection<int, PatientAudit> $patientAudit
 * @property-read int|null $patient_audit_count
 * @property-read Collection<int, PatientVitalSign> $patientVitalSigns
 * @property-read int|null $patient_vital_signs_count
 * @property-read Province|null $province
 * @property-read PatientStatus $status
 * @property-read PatientSuffix|null $suffix
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient orWhereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCivilStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereContactNumber2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFirstNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereLastNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMiddleNameIndex($value)
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
 * @property-read string|null $age_computed
 * @property-read string|null $full_address
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

    'first_name_index',
    'middle_name_index',
    'last_name_index',

    'created_by',
    'last_modified_by',
])]
class Patient extends Model implements CipherSweetEncrypted
{
    use CorrectTimezone, HasUuids, PersonDetails, UsesCipherSweet;

    protected $appends = ['full_name', 'full_address', 'age_computed'];

    protected function casts(): array
    {
        return [
            'last_name'   => 'encrypted',
            'first_name'  => 'encrypted',
            'middle_name' => 'encrypted',

            'date_of_birth'   => EncryptedDate::class,
            'age'             => 'encrypted',
            'contact_number1' => 'encrypted',
            'contact_number2' => 'encrypted',
            'email'           => 'encrypted',
            'occupation'      => 'encrypted',
            'philhealth_id'   => 'encrypted',
            'house_no'        => 'encrypted',
            'street'          => 'encrypted',
            'photo'           => 'encrypted',

            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
        ];
    }

    public function getFullNameAttribute(): string
    {
        $fullName = $this->last_name.', '.$this->first_name.($this->middle_name ? ' '.$this->middle_name : '');

        if (empty($this->suffix)) {
            return $fullName;
        }

        return $fullName.' '.$this->suffix->name;
    }

    public function suffix(): BelongsTo
    {
        return $this->belongsTo(PatientSuffix::class, 'patient_suffix_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PatientStatus::class, 'status_id', 'id');
    }

    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class, 'civil_status_id', 'id');
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
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

    public function consultation(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function laboratory(): HasMany
    {
        return $this->hasMany(Laboratory::class);
    }

    public function patientAudit(): HasMany
    {
        return $this->hasMany(PatientAudit::class);
    }

    /**
     * Configure CipherSweet fields and blind indexes.
     */
    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField('first_name_index', Constants::TYPE_TEXT)
            ->addField('middle_name_index', Constants::TYPE_OPTIONAL_TEXT)
            ->addField('last_name_index', Constants::TYPE_TEXT)
            ->addBlindIndex('first_name_index', new BlindIndex('first_name_index', [new Lowercase]))
            ->addBlindIndex('middle_name_index', new BlindIndex('middle_name_index', [new Lowercase]))
            ->addBlindIndex('last_name_index', new BlindIndex('last_name_index', [new Lowercase]));
    }
}
