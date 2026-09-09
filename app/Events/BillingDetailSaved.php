<?php

namespace App\Events;

use App\Models\BillingDetail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BillingDetailSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public BillingDetail $billingDetail,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
