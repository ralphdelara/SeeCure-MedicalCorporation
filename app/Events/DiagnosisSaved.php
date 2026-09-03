<?php

namespace App\Events;

use App\Models\ConsultationDiagnosis;
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
        public ConsultationDiagnosis $diagnosis,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
