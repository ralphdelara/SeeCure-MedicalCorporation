<?php

namespace App\Traits;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Gender;
use App\Models\Province;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PersonDetails
{
    // custom parameters
    public function getAgeComputedAttribute(): ?string
    {
        return computeExactAge($this->date_of_birth);
    }

    // relationships

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
