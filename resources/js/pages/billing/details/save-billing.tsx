import { completeBilling } from '@/actions/App/Http/Controllers/BillingController';
import ConfirmButton from '@/components/confirm-button';
import { billing } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';

const SaveBilling = () => {
    const { billingDetails } = usePage().props as unknown as {
        billingDetails: {
            id: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeBilling(billingDetails.id).url}
            msg={
                'This will move the patient to "Cashier" and the billing will be marked as completed!'
            }
            title="Save Billing"
            successTitle="Success!"
            successMsg="The billing record has been saved."
            successUrl={billing().url}
            size="lg"
        >
            <IconDeviceFloppy />
            Save Billing
        </ConfirmButton>
    );
};

export default SaveBilling;
