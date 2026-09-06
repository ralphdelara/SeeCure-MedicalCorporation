<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\DiagnosisSaved;
use App\Models\ConsultationAudit;
use App\Models\ConsultationDiagnosis;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use Log;

class LogDiagnosisSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(DiagnosisSaved $event): void
    {
        $diagnosis = $event->diagnosis;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($diagnosis);
        } else {
            $data = $this->updated($diagnosis, $savedFields, $originalFields);
        }
/*
        ConsultationAudit::create([
            'consultation_id' => $diagnosis->consultation_id,
            'audit_type_id'   => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'            => json_encode($data),
            'created_by'      => Auth::id(),
        ]);*/
    }

    public function created(ConsultationDiagnosis $diagnosis): array
    {
        $fields = $diagnosis->getAttributes();

        $this->removeUnimportantFields($fields);

        return [
            'title'  => 'Diagnosis has been added.',
            'fields' => [
                [
                    'field' => 'Diagnosis',
                    'to'    => $diagnosis->diagnosis,
                ],
            ],
        ];
    }

    public function updated(
        ConsultationDiagnosis $diagnosis,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($diagnosis->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                    Log::error($e->getMessage());
                }
            }

            $castType = $diagnosis->getCasts()[$field] ?? '';
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
            'title'  => 'Diagnosis has been updated.',
            'fields' => $fields,
        ];
    }

    private function removeUnimportantFields(array &$fields): void
    {
        $exclude = [
            'id', 'consultation_id',
            'created_by', 'created_at',
            'last_modified_by', 'updated_at',
        ];

        foreach ($exclude as $key) {
            unset($fields[$key]);
        }
    }
}
