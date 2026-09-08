<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\LaboratorySaved;
use App\Models\Laboratory;
use App\Models\LaboratoryAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogLaboratorySave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(LaboratorySaved $event): void
    {
        $laboratory = $event->laboratory;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($laboratory);
        } else {
            $data = $this->updated($laboratory, $savedFields, $originalFields);
        }

        LaboratoryAudit::create([
            'laboratory_id' => $laboratory->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Laboratory $laboratory): array
    {
        $laboratory->getAttributes();

        return [
            'title'  => 'Laboratory has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Laboratory $laboratory,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($laboratory->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $laboratory->getCasts()[$field] ?? '';
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
            'title'  => 'Laboratory has been updated.',
            'fields' => $fields,
        ];
    }
}
