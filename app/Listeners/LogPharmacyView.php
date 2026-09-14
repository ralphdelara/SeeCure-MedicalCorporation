<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PharmacyViewed;
use App\Models\PharmacyAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogPharmacyView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PharmacyViewed $event): void
    {
        $pharmacy = $event->pharmacy;
        $previousRow = PharmacyAudit::with('createdBy')->where('pharmacy_id', '=', $pharmacy->id)
            ->where('audit_type_id', '=', AuditTypeEnum::VIEW)
            ->latest('created_at')
            ->first();

        if ($previousRow) {
            /** @var Carbon $createdAt */
            $createdAt = $previousRow->created_at;
            $minutesDifference = $createdAt->diffInMinutes(now());

            // this prevents duplicate view log if same user keeps refreshing the page
            if (
                $previousRow->createdBy->id !== Auth::id()
                || $minutesDifference <= 9
            ) {
                return;
            }
        }

        $data = [
            'title'  => 'Pharmacy details have been viewed.',
            'fields' => [],
        ];

        PharmacyAudit::create([
            'pharmacy_id'    => $event->pharmacy->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
