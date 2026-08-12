<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\EncryptedDate;
use App\Traits\CorrectTimezone;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $username
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $full_name_index
 * @property int|null $gender_id
 * @property \Carbon\Carbon|null $date_of_birth
 * @property string|null $contact_number
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $license_no
 * @property string|null $ptr_no
 * @property \Carbon\Carbon|null $date_hired
 * @property \Carbon\Carbon|null $date_resigned
 * @property bool $status
 * @property int $position_id
 * @property int $created_by
 * @property string|null $photo
 * @property-read Collection<int, UserAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read User|null $createdBy
 * @property-read Collection<int, UserDepartment> $departments
 * @property-read int|null $departments_count
 * @property-read Gender|null $gender
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Position $position
 * @property-read Collection<int, UserProfession> $professions
 * @property-read int|null $professions_count
 * @property-read Province|null $province
 * @property-read Collection<int, UserRole> $role
 * @property-read int|null $role_count
 * @property-read Collection<int, UserSpecialty> $specialties
 * @property-read int|null $specialties_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateHired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateResigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePtrNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'username',
    'password',
    'first_name',
    'middle_name',
    'last_name',
    'gender_id',
    'date_of_birth',
    'contact_number',
    'email',

    'house_no',
    'street',
    'barangay_id',
    'city_id',
    'province_id',

    'license_no',
    'ptr_no',

    'date_hired',
    'date_resigned',
    'status',
    'position_id',
    'created_by',
    'last_modified_by',
    'photo',
])]
#[Hidden([
    'password',
    'two_factor_secret',
    'two_factor_recovery_codes',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, CorrectTimezone;

    protected $appends = ['full_name'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password'      => 'hashed',
            'first_name'    => 'encrypted',
            'middle_name'   => 'encrypted',
            'last_name'     => 'encrypted',
            'date_of_birth' => EncryptedDate::class,

            'contact_number' => 'encrypted',
            'email'          => 'encrypted',

            'house_no' => 'encrypted',
            'street'   => 'encrypted',

            'license_no' => 'encrypted',
            'ptr_no'     => 'encrypted',

            'date_hired'    => EncryptedDate::class,
            'date_resigned' => EncryptedDate::class,
            'status'        => 'encrypted:boolean',

            'photo' => 'encrypted',
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

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(UserDepartment::class);
    }

    public function professions(): HasMany
    {
        return $this->hasMany(UserProfession::class);
    }

    public function specialties(): HasMany
    {
        return $this->hasMany(UserSpecialty::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(UserAudit::class);
    }

    public function role(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }
}
