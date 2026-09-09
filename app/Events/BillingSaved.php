<?php

namespace App\Events;

use App\Models\Billing;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BillingSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public Billing $billing,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
