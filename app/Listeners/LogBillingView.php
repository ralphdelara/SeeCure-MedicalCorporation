<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\BillingViewed;
use App\Models\BillingAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogBillingView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(BillingViewed $event): void
    {
        $billing = $event->billing;
        $previousRow = BillingAudit::with('createdBy')->where('billing_id', '=', $billing->id)
            ->where('audit_type_id', '=', AuditTypeEnum::VIEW)
            ->latest('created_at')
            ->first();

        if ($previousRow) {
            /** @var Carbon $createdAt */
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
            'title'  => 'Billing details have been viewed.',
            'fields' => [],
        ];

        BillingAudit::create([
            'billing_id'    => $event->billing->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
