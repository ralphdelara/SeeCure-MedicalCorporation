<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $consultation_id
 * @property string|null $inventory_id
 * @property string $inventory_name
 * @property string $quantity
 * @property string $sig
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereInventoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereSig($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'inventory_id',
    'inventory_name',
    'quantity',
    'sig',
    'created_by',
    'last_modified_by',
])]
class Prescription extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'inventory_name' => 'encrypted',
            'sig'            => 'encrypted',
            'inventory_id'   => 'encrypted',
            'created_at'     => 'date:M d, Y h:i a',
            'updated_at'     => 'date:M d, Y h:i a',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
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
