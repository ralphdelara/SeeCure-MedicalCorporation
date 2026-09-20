<?php

namespace App\Events;

use App\Models\Diagnosis;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DiagnosisSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Diagnosis $diagnosis,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
