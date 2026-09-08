<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\Icd10CodeSaved;
use App\Models\ConsultationAudit;
use Illuminate\Support\Facades\Auth;

class LogSignsOrSymptomsSave
{
    /**
     * Handle the event.
     */
    public function handle(Icd10CodeSaved $event): void
    {
        $icd10CodeAudit = $event->icd10CodeAudit;
        $consultationId = $event->consultationId;

        $data = [
            'title'  => 'ICD10 Code has been updated.',
            'fields' => [[
                'field'   => 'ICD10 Code',
                'added'   => implode(', ', $icd10CodeAudit['added']),
                'deleted' => implode(', ', $icd10CodeAudit['deleted']),
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
