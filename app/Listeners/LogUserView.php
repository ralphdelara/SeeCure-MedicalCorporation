<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\UserViewed;
use App\Models\UserAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogUserView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(UserViewed $event): void
    {
        $user = $event->user;
        $previousRow = UserAudit::with('createdBy')->where('user_id', '=', $user->id)
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
            'title'  => 'User details have been viewed.',
            'fields' => [],
        ];

        UserAudit::create([
            'user_id'       => $event->user->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
