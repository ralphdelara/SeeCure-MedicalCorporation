<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $document_id
 * @property string $data
 * @property-read \App\Models\Document $document
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalCertificate whereId($value)
 * @mixin \Eloquent
 */
#[Fillable([
    'document_id',
    'data',
])]
class MedicalCertificate extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'data' => 'encrypted',
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
}
