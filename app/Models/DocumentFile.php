<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $document_id
 * @property string $file_path
 * @property string $file_name
 * @property string $file_size
 * @property string $file_mime_type
 * @property string $file_ext
 * @property-read \App\Models\Document $document
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereFileExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereFileMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentFile whereId($value)
 * @mixin \Eloquent
 */
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
