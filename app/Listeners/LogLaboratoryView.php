<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\LaboratoryViewed;
use App\Models\LaboratoryAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogLaboratoryView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(LaboratoryViewed $event): void
    {
        $laboratory = $event->laboratory;
        $previousRow = LaboratoryAudit::with('createdBy')->where('laboratory_id', '=', $laboratory->id)
            ->where('audit_type_id', '=', AuditTypeEnum::VIEW)
            ->latest('created_at')
            ->first();

        if ($previousRow) {
            $createdAt = $previousRow->created_at;
            $minutesDifference = $createdAt->diffInMinutes(now());

            // this prevents duplicate view log if same user keeps refreshing the page
            if (
                $previousRow->createdBy->id === Auth::id()
                && $minutesDifference <= 5
            ) {
                return;
            }
        }

        $data = [
            'title'  => 'Laboratory details have been viewed.',
            'fields' => [],
        ];

        LaboratoryAudit::create([
            'laboratory_id' => $event->laboratory->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
