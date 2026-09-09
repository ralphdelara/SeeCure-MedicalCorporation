<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Visit;

class FrontDeskService
{
    public function moveVisit(string $visitId, VisitStatusEnum $visitStatus): void
    {
        Visit::find($visitId)
            ->update([
                'visit_status_id' => $visitStatus,
            ]);
    }
}
