<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\ConsultationViewed;
use App\Models\ConsultationAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogConsultationView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ConsultationViewed $event): void
    {
        $consultation = $event->consultation;
        $previousRow = ConsultationAudit::with('createdBy')->where('consultation_id', '=', $consultation->id)
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
            'title'  => 'Consultation details have been viewed.',
            'fields' => [],
        ];

        ConsultationAudit::create([
            'consultation_id' => $event->consultation->id,
            'audit_type_id'   => AuditTypeEnum::VIEW,
            'data'            => json_encode($data),
            'created_by'      => Auth::id() ?? Auth::systemUser()->id,
        ]);
    }
}
