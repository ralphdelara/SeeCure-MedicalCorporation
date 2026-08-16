<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $department_id
 * @property-read Department $department
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDepartment whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'user_id',
    'department_id',
])]
class UserDepartment extends Model
{
    use HasUuids;

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
