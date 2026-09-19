<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PatientSaved;
use App\Models\Patient;
use App\Models\PatientAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogPatientSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PatientSaved $event): void
    {
        $patient = $event->patient;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($patient);
        } else {
            $data = $this->updated($patient, $savedFields, $originalFields);
        }

        PatientAudit::create([
            'patient_id' => $patient->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Patient $patient): array
    {
        $patient->getAttributes();

        return [
            'title'  => 'Patient has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Patient $patient,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($patient->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $patient->getCasts()[$field] ?? '';
            $isDate = str_starts_with($castType, 'date') || str_starts_with($castType, 'datetime');

            if ($isDate) {
                // Safely extract the format or fall back to your default string template
                $format = str_contains($castType, ':')
                    ? explode(':', $castType, 2)[1]
                    : 'M d Y, h:i:s a';

                // Safely parse and convert values with Carbon
                if ($oldValue) {
                    $oldValue = Carbon::parse($oldValue)->format($format);
                }
                if ($newValue) {
                    $newValue = Carbon::parse($newValue)->format($format);
                }
            }

            $fields[] = [
                'field' => $field,
                'from'  => $oldValue,
                'to'    => $newValue,
            ];
        }

        return [
            'title'  => 'Patient has been updated.',
            'fields' => $fields,
        ];
    }
}
