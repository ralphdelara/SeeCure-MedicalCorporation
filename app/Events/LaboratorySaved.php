<?php

namespace App\Events;

use App\Models\Laboratory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LaboratorySaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * type can be 'created' or 'updated'
     */
    public function __construct(
        public Laboratory $laboratory,
        public string $type,
        public array $savedFields = [],
        public array $originalFields = [],
    ) {}
}
