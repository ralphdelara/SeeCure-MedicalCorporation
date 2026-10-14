<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PrescriptionSaved;
use App\Models\ConsultationAudit;
use App\Models\Prescription;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use Log;

class LogPrescriptionSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PrescriptionSaved $event): void
    {
        $prescription = $event->prescription;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        $data = match ($type) {
            'created' => $this->created($prescription),
            'deleted' => $this->deleted($prescription),
            default   => $this->updated($prescription, $savedFields, $originalFields),
        };

        $auditType = match ($type) {
            'created' => AuditTypeEnum::ADD,
            'deleted' => AuditTypeEnum::DELETE,
            default   => AuditTypeEnum::UPDATE,
        };

        ConsultationAudit::create([
            'consultation_id' => $prescription->consultation_id,
            'audit_type_id'   => $auditType,
            'data'            => json_encode($data),
            'created_by'      => Auth::id() ?? Auth::systemUser()->id,
        ]);
    }

    public function created(Prescription $prescription): array
    {
        return [
            'title'  => 'Prescription has been added.',
            'fields' => [
                [
                    'field' => 'inventory_name',
                    'to'    => $prescription->inventory_name,
                ], [
                    'field' => 'quantity',
                    'to'    => $prescription->quantity,
                ], [
                    'field' => 'sig',
                    'to'    => $prescription->sig,
                ],
            ],
        ];
    }

    public function updated(
        Prescription $prescription,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        $this->removeUnimportantFields($savedFields);

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($prescription->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                    Log::error($e->getMessage());
                }
            }

            $castType = $prescription->getCasts()[$field] ?? '';
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
            'title'  => 'Prescription has been updated.',
            'fields' => $fields,
        ];
    }

    public function deleted(Prescription $prescription): array
    {
        return [
            'title'  => 'Prescription has been deleted.',
            'fields' => [
                [
                    'field' => 'inventory_name',
                    'to'    => $prescription->inventory_name,
                ], [
                    'field' => 'quantity',
                    'to'    => $prescription->quantity,
                ], [
                    'field' => 'sig',
                    'to'    => $prescription->sig,
                ],
            ],
        ];
    }

    private function removeUnimportantFields(array &$savedFields): void
    {
        $fields = [
            'id', 'consultation_id', 'inventory_id',
            'created_by', 'created_at',
            'last_modified_by', 'updated_at',
        ];

        foreach ($fields as $field) {
            unset($savedFields[$field]);
        }
    }
}
