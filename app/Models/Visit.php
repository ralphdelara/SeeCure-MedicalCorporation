<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'patient_id',
    'has_consultation',
    'has_laboratory',
    'has_radiology',
    'created_by',
    'last_modified_by',
])]
class Visit extends Model
{
    use CorrectTimezone;

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lastModifiedBy(): ?BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class);
    }
}
