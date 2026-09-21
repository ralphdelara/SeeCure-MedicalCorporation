<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'document_id',
    'file_path',
    'file_name',
    'file_size',
    'file_mime_type',
    'file_ext',
])]
class DocumentFile extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'file_path' => 'encrypted',
            'file_name' => 'encrypted',
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
}
