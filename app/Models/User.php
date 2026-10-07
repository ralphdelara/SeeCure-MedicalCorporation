<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\EncryptedDate;
use App\Enums\DepartmentEnum;
use App\Enums\PositionEnum;
use App\Traits\CorrectTimezone;
use App\Traits\PersonDetails;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\Constants;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\Transformation\Lowercase;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;

/**
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property int|null $gender_id
 * @property string|null $date_of_birth
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $house_no
 * @property string|null $street
 * @property int|null $barangay_id
 * @property int|null $city_id
 * @property int|null $province_id
 * @property string|null $license_no
 * @property string|null $ptr_no
 * @property string|null $date_hired
 * @property string|null $date_resigned
 * @property bool $status
 * @property string|null $remember_token
 * @property string|null $photo
 * @property string|null $last_name_index
 * @property string|null $first_name_index
 * @property string|null $middle_name_index
 * @property int|null $batch
 * @property string|null $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, UserAudit> $audits
 * @property-read int|null $audits_count
 * @property-read Barangay|null $barangay
 * @property-read City|null $city
 * @property-read User|null $createdBy
 * @property-read Department $department
 * @property-read Gender|null $gender
 * @property-read string $full_name
 * @property-read User|null $lastModifiedBy
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, UserProfession> $professions
 * @property-read int|null $professions_count
 * @property-read Province|null $province
 * @property-read Collection<int, UserSpecialty> $specialties
 * @property-read int|null $specialties_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User orWhereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBlind(string $column, string $indexName, array|string $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateHired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateResigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHouseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastNameIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleNameIndex($value)
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
 * @property string|null $username_index
 * @property-read string|null $age_computed
 * @property-read string|null $full_address
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsernameIndex($value)
 * @property-read string $full_name_receipt
 * @property-read Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read bool $is_admin
 * @property-read bool $is_bot
 * @property-read Collection<int, \App\Models\Position> $positions
 * @property-read int|null $positions_count
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

    'username_index',
    'first_name_index',
    'middle_name_index',
    'last_name_index',

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
class User extends Authenticatable implements CipherSweetEncrypted
{
    /** @use HasFactory<UserFactory> */
    use CorrectTimezone, HasFactory, HasUuids, Notifiable, PersonDetails, UsesCipherSweet;

    protected $appends = ['physician_last_name', 'full_name', 'full_address', 'age_computed', 'full_name_receipt', 'is_bot', 'is_admin'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'username'    => 'encrypted',
            'last_name'   => 'encrypted',
            'first_name'  => 'encrypted',
            'middle_name' => 'encrypted',

            'password'      => 'hashed',
            'date_of_birth' => EncryptedDate::class,

            'contact_number' => 'encrypted',
            'email'          => 'encrypted',

            'house_no' => 'encrypted',
            'street'   => 'encrypted',

            'license_no' => 'encrypted',
            'ptr_no'     => 'encrypted',

            'date_hired'    => EncryptedDate::class,
            'date_resigned' => EncryptedDate::class,

            'photo'      => 'encrypted',
            'created_at' => 'date:M d, Y H:i a',
        ];
    }

    public function getFullNameAttribute(): string
    {
        //  Get the base name
        $fullName = $this->last_name.', '.$this->first_name.($this->middle_name ? ' '.$this->middle_name : '');

        // 2. Check if professions are eager-loaded, then extract the names
        if ($this->relationLoaded('professions')) {
            $prefix = $this->professions->pluck('prefix')->filter()->implode(', ');
            $suffix = $this->professions->pluck('suffix')->filter()->implode(', ');

            return $prefix.$fullName.($suffix ? ' '.$suffix : '');
        }

        return $fullName;
    }

    public function getFullNameReceiptAttribute(): string
    {
        //  Get the base name
        $fullName = $this->first_name.' '.($this->middle_name ? $this->middle_name.' ' : '').$this->last_name;

        // 2. Check if professions are eager-loaded, then extract the names
        if ($this->relationLoaded('professions')) {
            $prefix = $this->professions->pluck('prefix')->filter()->implode(', ');
            $suffix = $this->professions->pluck('suffix')->filter()->implode(', ');

            return $prefix.$fullName.($suffix ? ' '.$suffix : '');
        }

        return $fullName;
    }

    public function getPhysicianLastNameAttribute(): string
    {
        //  Get the base name
        $fullName = $this->last_name;

        // Check if professions are eager-loaded, then extract the names
        if ($this->relationLoaded('professions')) {
            $prefix = $this->professions->pluck('prefix')->filter()->implode(', ');
            $suffix = $this->professions->pluck('suffix')->filter()->implode(', ');

            return $prefix.$this->last_name.($suffix ? ' '.$suffix : '');
        }

        return $fullName;
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'user_departments', 'user_id', 'department_id');
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'user_positions', 'user_id', 'position_id');
    }

    public function professions(): BelongsToMany
    {
        return $this->belongsToMany(Profession::class, 'user_professions', 'user_id', 'profession_id');
    }

    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class, 'user_specialties', 'user_id', 'specialty_id');
    }

    public function audits(): HasMany
    {
        return $this->hasMany(UserAudit::class);
    }

    public function getIsBotAttribute(): bool
    {
        foreach ($this->positions as $position) {
            if (PositionEnum::tryFrom($position->id) === PositionEnum::BOT) {
                return true;
            }
        }

        return false;
    }

    public function getIsAdminAttribute(): bool
    {
        foreach ($this->departments as $department) {
            if (DepartmentEnum::tryFrom($department->id) === DepartmentEnum::ADMINISTRATOR) {
                return true;
            }
        }

        return false;
    }

    /**
     * Configure CipherSweet fields and blind indexes.
     */
    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField('username_index', Constants::TYPE_TEXT)
            ->addField('first_name_index', Constants::TYPE_TEXT)
            ->addField('middle_name_index', Constants::TYPE_OPTIONAL_TEXT)
            ->addField('last_name_index', Constants::TYPE_TEXT)
            ->addBlindIndex('username_index', new BlindIndex('username_index'))
            ->addBlindIndex('first_name_index', new BlindIndex('first_name_index', [new Lowercase]))
            ->addBlindIndex('middle_name_index', new BlindIndex('middle_name_index', [new Lowercase]))
            ->addBlindIndex('last_name_index', new BlindIndex('last_name_index', [new Lowercase]));
    }
}
