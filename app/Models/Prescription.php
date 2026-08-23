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
 * @property string|null $product_id
 * @property string $product_name
 * @property string $quantity
 * @property string $dosage
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Consultation $consultation
 * @property-read User $createdBy
 * @property-read User|null $lastModifiedBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prescription whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Fillable([
    'consultation_id',
    'product_id',
    'quantity',
    'dosage',
    'created_by',
    'last_modified_by',
])]
class Prescription extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'dosage' => 'encrypted',
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
