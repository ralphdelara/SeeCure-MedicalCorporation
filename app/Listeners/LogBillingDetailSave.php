<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\BillingDetailSaved;
use App\Models\BillingAudit;
use App\Models\BillingDetail;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogBillingDetailSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(BillingDetailSaved $event): void
    {
        $billingDetail = $event->billingDetail;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($billingDetail);
        } else {
            $data = $this->updated($billingDetail, $savedFields, $originalFields);
        }

        BillingAudit::create([
            'billing_id' => $billingDetail->billing_id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(BillingDetail $billing): array
    {
        $billing->getAttributes();

        return [
            'title'  => 'Billing Detail has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        BillingDetail $billing,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

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
            'title'  => 'Billing Detail has been updated.',
            'fields' => $fields,
        ];
    }
}
