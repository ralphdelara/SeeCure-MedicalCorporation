<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'policy',
    'created_by',
    'last_modified_by',
])]
class PrivacyPolicy extends Model
{
    use CorrectTimezone;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d, Y h:i:s a',
            'updated_at' => 'date:M d, Y h:i:s a',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }
}
