<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public Payment $payment,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
