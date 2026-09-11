<?php

namespace App\Events;

use App\Models\CashierDetail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CashierDetailSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public CashierDetail $cashierDetail,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
