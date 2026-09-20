<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $transaction_no
 * @property string $pharmacy_id
 * @property string $created_by
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Pharmacy $pharmacy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyPickList whereTransactionNo($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'pharmacy_id',
    'created_by',
])]
class PharmacyPickList extends Model
{
    use CorrectTimezone;

    protected $primaryKey = 'transaction_no';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
