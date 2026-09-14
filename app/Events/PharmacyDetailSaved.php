<?php

namespace App\Events;

use App\Models\PharmacyDetail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PharmacyDetailSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public PharmacyDetail $pharmacyDetail,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
