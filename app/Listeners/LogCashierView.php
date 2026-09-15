<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\CashierViewed;
use App\Models\CashierAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogCashierView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(CashierViewed $event): void
    {
        $cashier = $event->cashier;
        $previousRow = CashierAudit::with('createdBy')->where('cashier_id', '=', $cashier->id)
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
            'title'  => 'Cashier details have been viewed.',
            'fields' => [],
        ];

        CashierAudit::create([
            'cashier_id'    => $event->cashier->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
