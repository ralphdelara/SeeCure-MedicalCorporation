<?php

namespace App\Observers;

use App\Events\PaymentSaved;
use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        PaymentSaved::dispatch($payment, 'created');
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        if (! $payment->wasChanged()) {
            return;
        }

        // Placed here because getChanges doesnt work if passed as parameter
        $changedFields = $payment->getChanges();
        $originalFields = $payment->getOriginal();

        PaymentSaved::dispatch($payment, 'updated', $changedFields, $originalFields);
    }
}
