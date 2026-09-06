<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereName($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
])]
class Position extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
        ];
    }
}
