<?php

namespace App\Events;

use App\Models\ConsultationSoap;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SoapSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ConsultationSoap $soap,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
