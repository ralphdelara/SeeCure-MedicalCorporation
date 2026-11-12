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
            billing_id?: string|null
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeCashier(cashierDetails.id).url}
            msg={
                cashierDetails.moveToText !== 'Completed'
                ? 'This will move the patient to "' + cashierDetails.moveToText + '" and the cashier will be marked as completed!'
                : (cashierDetails.billing_id !== null
                    ? 'This will complete the patient\'s visit. They are free to proceed to the pharmacy if they wish to purchase their medication.'
                    : 'This will complete the pharmacy transaction.')
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
