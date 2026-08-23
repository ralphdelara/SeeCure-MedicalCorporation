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
    public function getFullNameAttribute(): string
    {
        return $this->last_name.', '.$this->first_name.($this->middle_name ? ' '.$this->middle_name : '');
    }

    public function getAgeComputedAttribute(): ?string
    {
        return computeExactAge($this->date_of_birth);
    }

    // relationships

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
}
