<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $user_id
 * @property int $position_id
 * @property-read \App\Models\Position $position
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPosition whereUserId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'position_id',
])]

class UserPosition extends Model
{
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
