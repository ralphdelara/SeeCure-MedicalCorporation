<?php

namespace App\Models;

use App\Traits\CorrectTimezone;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $inventory_id
 * @property int $audit_type_id
 * @property string $data
 * @property string $created_by
 * @property CarbonImmutable $created_at
 * @property-read \App\Models\AuditType $auditType
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Inventory $inventory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereAuditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryAudit whereInventoryId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'inventory_id',
    'audit_type_id',
    'data',
    'created_by',
])]
class InventoryAudit extends Model
{
    use CorrectTimezone;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'data'       => 'encrypted',
            'created_at' => 'date:M d Y, h:i:s a',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function auditType(): BelongsTo
    {
        return $this->belongsTo(AuditType::class, 'audit_type_id', 'id');
    }
}
