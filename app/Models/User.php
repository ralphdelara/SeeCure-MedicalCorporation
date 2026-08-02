<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\EncryptedDate;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use ParagonIE\CipherSweet\BlindIndex;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\Transformation\Lowercase;

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

    'photo',

    'date_hired',
    'date_resigned',
    'status',
    'position_id',
    'created_by',
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
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'first_name' => 'encrypted',
            'middle_name' => 'encrypted',
            'last_name' => 'encrypted',
            'date_of_birth' => EncryptedDate::class,

            'contact_number' => 'encrypted',
            'email' => 'encrypted',

            'house_no' => 'encrypted',
            'street' => 'encrypted',

            'photo' => 'encrypted',

            'date_hired' => EncryptedDate::class,
            'date_resigned' => EncryptedDate::class,
            'status' => 'encrypted:boolean',
        ];
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
