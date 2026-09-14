import { completeBilling } from '@/actions/App/Http/Controllers/BillingController';
import ConfirmButton from '@/components/confirm-button';
import { billing } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const ConfirmBilling = () => {
    const { billingDetails } = usePage().props as unknown as {
        billingDetails: {
            id: string;
            moveToText: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeBilling(billingDetails.id).url}
            msg={
                'This will move the patient to "' + billingDetails.moveToText + '" and the billing will be marked as completed!'
            }
            title="Complete Billing"
            successTitle="Success!"
            successMsg="The billing record has been completed."
            successUrl={billing().url}
            size="lg"
        >
            <IconChecklist />
            Complete Billing
        </ConfirmButton>
    );
};

export default ConfirmBilling;
