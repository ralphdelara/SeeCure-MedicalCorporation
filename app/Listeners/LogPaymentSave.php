<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\PaymentSaved;
use App\Models\CashierAudit;
use App\Models\Payment;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogPaymentSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PaymentSaved $event): void
    {
        $payment = $event->payment;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($payment);
        } else {
            $data = $this->updated($payment, $savedFields, $originalFields);
        }

        CashierAudit::create([
            'cashier_id'    => $payment->cashier_id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id(),
        ]);
    }

    private function created(Payment $payment): array
    {
        $payment->getAttributes();

        return [
            'title'  => 'Payment has been added.',
            'fields' => [],
        ];
    }

    private function updated(
        Payment $payment,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];

        foreach ($savedFields as $field => $newValue) {
            $oldValue = $originalFields[$field];

            if ($payment->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $payment->getCasts()[$field] ?? '';
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
            'title'  => 'Payment has been updated.',
            'fields' => $fields,
        ];
    }
}
