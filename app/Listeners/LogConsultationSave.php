<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\ConsultationSaved;
use App\Models\Consultation;
use App\Models\ConsultationAudit;
use App\Models\Relationship;
use App\Models\User;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogConsultationSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ConsultationSaved $event): void
    {
        $consultation = $event->consultation;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        $consultation->loadMissing(['guardianRelationship', 'doctor', 'createdBy', 'lastModifiedBy']);

        if ($type === 'created') {
            $data = $this->created($consultation);
        } else {
            $data = $this->updated($consultation, $savedFields, $originalFields);
        }

        ConsultationAudit::create([
            'consultation_id' => $consultation->id,
            'audit_type_id'   => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'            => json_encode($data),
            'created_by'      => Auth::id(),
        ]);
    }

    private function created(Consultation $consultation): array
    {
        $fields = $consultation->getAttributes();

        $this->removeUnimportantFields($fields);

        return [
            'title'  => 'Consultation has been added.',
            'fields' => [
                [
                    'field' => 'Guardian Relationship',
                    'to'    => $consultation->guardianRelationship?->name,
                ],
                [
                    'field' => 'Doctor',
                    'to'    => $consultation->doctor->full_name,
                ],
            ],
        ];
    }

    private function updated(
        Consultation $consultation,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($consultation->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            // Handle doctor changes
            if ($field === 'doctor_id') {
                $field = 'doctor';
                $oldValue = User::find($oldValue)->full_name ?? 'Unknown';
                $newValue = $consultation->doctor->full_name ?? 'Unknown';
            }

            // Handle guardian relationship changes
            if ($field === 'guardian_relationship_id') {
                $field = 'guardian_relationship';
                $oldValue = Relationship::find($oldValue)->name ?? 'N/A';
                $newValue = $consultation->guardianRelationship->name ?? 'N/A';
            }

            $castType = $consultation->getCasts()[$field] ?? '';
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
            'title'  => 'Consultation has been updated.',
            'fields' => $fields,
        ];
    }

    private function removeUnimportantFields(array &$fields): void
    {
        $exclude = [
            'id', 'visit_id', 'patient_id', 'follow_up_date',
            'created_by', 'created_at',
            'last_modified_by', 'updated_at', 'doctor_id', 'guardian_relationship_id',
        ];

        foreach ($exclude as $key) {
            unset($fields[$key]);
        }
    }
}
