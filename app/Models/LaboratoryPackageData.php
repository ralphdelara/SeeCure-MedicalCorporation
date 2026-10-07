<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'laboratory_id',
    'laboratory_package_id',
])]
class LaboratoryPackageData extends Model
{
    public $table = 'laboratory_package_data';
    public $timestamps = false;

    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(LaboratoryPackage::class);
    }
}
