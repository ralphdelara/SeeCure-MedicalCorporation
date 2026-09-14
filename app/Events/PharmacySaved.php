<?php

namespace App\Events;

use App\Models\Pharmacy;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PharmacySaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public Pharmacy $pharmacy,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
