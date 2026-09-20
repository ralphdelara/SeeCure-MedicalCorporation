<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PharmacySaved;
use App\Models\Pharmacy;
use App\Models\PharmacyAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogPharmacySave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PharmacySaved $event): void
    {
        $pharmacy = $event->pharmacy;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($pharmacy);
        } else {
            $data = $this->updated($pharmacy, $savedFields, $originalFields);
        }

        PharmacyAudit::create([
            'pharmacy_id'   => $pharmacy->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Pharmacy $pharmacy): array
    {
        $pharmacy->getAttributes();

        return [
            'title'  => 'Pharmacy has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Pharmacy $pharmacy,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field] ?? '';

            if ($pharmacy->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $pharmacy->getCasts()[$field] ?? '';
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
            'title'  => 'Pharmacy has been updated.',
            'fields' => $fields,
        ];
    }
}
