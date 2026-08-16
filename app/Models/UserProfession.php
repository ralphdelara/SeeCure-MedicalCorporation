<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profession_id
 * @property-read Profession $profession
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfession whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'profession_id',
])]

class UserProfession extends Model
{
    use HasUuids;

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }
}
