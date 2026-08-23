<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $user_id
 * @property int $specialty_id
 * @property-read Specialty $specialty
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereSpecialtyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialty whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'specialty_id',
])]
class UserSpecialty extends Model
{
    use HasUuids;

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }
}
