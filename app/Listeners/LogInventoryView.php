<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\InventoryViewed;
use App\Models\InventoryAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogInventoryView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(InventoryViewed $event): void
    {
        $inventory = $event->inventory;
        $previousRow = InventoryAudit::with('createdBy')->where('inventory_id', '=', $inventory->id)
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
            'title'  => 'Inventory details have been viewed.',
            'fields' => [],
        ];

        InventoryAudit::create([
            'inventory_id'    => $event->inventory->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
