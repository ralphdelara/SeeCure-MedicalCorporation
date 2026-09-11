<?php

namespace App\Events;

use App\Models\Cashier;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CashierSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public Cashier $cashier,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
