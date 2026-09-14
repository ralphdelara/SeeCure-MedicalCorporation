import { completeCashier } from '@/actions/App/Http/Controllers/CashierController';
import ConfirmButton from '@/components/confirm-button';
import { cashier } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const CompleteCashier = () => {
    const { cashierDetails } = usePage().props as unknown as {
        cashierDetails: {
            id: string;
            moveToText: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeCashier(cashierDetails.id).url}
            msg={
                cashierDetails.moveToText !== 'Completed'
                ? 'This will move the patient to "' + cashierDetails.moveToText + '" and the cashier will be marked as completed!'
                : 'This will complete the Patient Visit.'
            }
            title="Complete Cashier"
            successTitle="Success!"
            successMsg="The cashier record has been completed."
            successUrl={cashier().url}
            size="lg"
        >
            <IconChecklist />
            Complete Cashier
        </ConfirmButton>
    );
};

export default CompleteCashier;
