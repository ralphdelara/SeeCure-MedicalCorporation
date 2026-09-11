import { completeCashier } from '@/actions/App/Http/Controllers/CashierController';
import ConfirmButton from '@/components/confirm-button';
import { cashier } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';

const SaveCashier = () => {
    const { cashierDetails } = usePage().props as unknown as {
        cashierDetails: {
            id: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeCashier(cashierDetails.id).url}
            msg={
                'This will move the patient to "Cashier" and the cashier will be marked as completed!'
            }
            title="Save Cashier"
            successTitle="Success!"
            successMsg="The cashier record has been saved."
            successUrl={cashier().url}
            size="lg"
        >
            <IconDeviceFloppy />
            Save Cashier
        </ConfirmButton>
    );
};

export default SaveCashier;
