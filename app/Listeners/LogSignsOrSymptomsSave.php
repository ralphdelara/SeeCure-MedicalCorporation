<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\SignsOrSymptomsSaved;
use App\Models\ConsultationAudit;
use Illuminate\Support\Facades\Auth;

class LogSignsOrSymptomsSave
{
    /**
     * Handle the event.
     */
    public function handle(SignsOrSymptomsSaved $event): void
    {
        $signsOrSymptomAudit = $event->signsOrSymptomAudit;
        $consultationId = $event->consultationId;

        $data = [
            'title'  => 'Signs Or Symptoms has been updated.',
            'fields' => [[
                'field'   => 'Signs Or Symptoms',
                'added'   => implode(', ', $signsOrSymptomAudit['added']),
                'deleted' => implode(', ', $signsOrSymptomAudit['deleted']),
            ]],
        ];

        ConsultationAudit::create([
            'consultation_id' => $consultationId,
            'audit_type_id'   => AuditTypeEnum::UPDATE,
            'data'            => json_encode($data),
            'created_by'      => Auth::id(),
        ]);
    }
}
