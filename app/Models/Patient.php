<?php

namespace App\Models;

use App\Casts\EncryptedDate;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'last_name',
    'first_name',
    'middle_name',
    'date_of_birth',
    'contact_number1',
    'contact_number2',
    'email',
    'occupation',

    'house_no',
    'street',
    'barangay_id',
    'city_id',
    'province_id',

    'photo',
    'credit_limit',

    'gender_id',
    'civil_status_id',
    'nationality_id',
    'status_id',
    'patient_suffix_id',
    'created_by',
])]
class Patient extends Model
{
    protected function casts(): array
    {
        return [
            'first_name' => 'encrypted',
            'middle_name' => 'encrypted',
            'last_name' => 'encrypted',
            'date_of_birth' => EncryptedDate::class,
            'contact_number1' => 'encrypted',
            'contact_number2' => 'encrypted',
            'email' => 'encrypted',
            'occupation' => 'encrypted',

            'house_no' => 'encrypted',
            'street' => 'encrypted',

            'guardian_name' => 'encrypted',
            'guardian_contact_number' => 'encrypted',
            'guardian_email' => 'encrypted',

            'photo' => 'encrypted',
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
        return $this->belongsTo(User::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(PatientAudit::class);
    }
}
