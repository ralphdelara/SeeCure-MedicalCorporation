<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property numeric|null $cost_price
 * @property int $stock
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillingSupplies whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'name',
    'cost_price',
    'stock',
    'created_by',
    'last_modified_by',
])]
class BillingSupplies extends Model
{
    use CorrectTimezone;

    public $table = 'billing_supplies';

    protected function casts(): array
    {
        return [
            'name'       => 'encrypted',
            'created_at' => 'date:M d, Y h:i a',
            'updated_at' => 'date:M d, Y h:i a',
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
