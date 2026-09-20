<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PatientViewed;
use App\Models\PatientAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogPatientView implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PatientViewed $event): void
    {
        $patient = $event->patient;
        $previousRow = PatientAudit::with('createdBy')->where('patient_id', '=', $patient->id)
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
            'title'  => 'Patient details have been viewed.',
            'fields' => [],
        ];

        PatientAudit::create([
            'patient_id'    => $event->patient->id,
            'audit_type_id' => AuditTypeEnum::VIEW,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }
}
