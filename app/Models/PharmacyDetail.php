<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $pharmacy_id
 * @property string $prescription_id
 * @property string $prescription_quantity
 * @property string $pharmacy_quantity
 * @property string $created_by
 * @property string|null $last_modified_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $lastModifiedBy
 * @property-read \App\Models\Pharmacy $pharmacy
 * @property-read \App\Models\Prescription $prescription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereLastModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePharmacyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail wherePrescriptionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PharmacyDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'pharmacy_id',
    'prescription_id',
    'prescription_quantity',
    'pharmacy_quantity',
    'created_by',
    'last_modified_by',
])]
class PharmacyDetail extends Model
{
    use CorrectTimezone, HasUuids;

    protected function casts(): array
    {
        return [
            'created_at' => 'date:M d Y, h:i:s a',
            'updated_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
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
