<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\BillingSaved;
use App\Models\Billing;
use App\Models\BillingAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogBillingSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(BillingSaved $event): void
    {
        $billing = $event->billing;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($billing);
        } else {
            $data = $this->updated($billing, $savedFields, $originalFields);
        }

        BillingAudit::create([
            'billing_id'    => $billing->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Billing $billing): array
    {
        $billing->getAttributes();

        return [
            'title'  => 'Billing has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Billing $billing,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field] ?? null;

            if ($billing->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $billing->getCasts()[$field] ?? '';
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
            'title'  => 'Billing has been updated.',
            'fields' => $fields,
        ];
    }
}
