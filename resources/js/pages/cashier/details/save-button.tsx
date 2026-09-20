import { Button } from '@/components/ui/button';
import {
    IconBuildingBank,
    IconChecklist,
    IconDeviceFloppy,
    IconExclamationCircleFilled,
    IconPrescription,
} from '@tabler/icons-react';
import { Link } from '@inertiajs/react';
import CompleteCashier from './complete-cashier';
import { usePage } from '@inertiajs/react';
import Swal from 'sweetalert2';
import { sendBackToBilling, sendBackToPharmacy } from '@/routes/cashier/details';
import SendToBilling from './send-to-billing';
import SendToPharmacy from './send-to-pharmacy';

const SaveButton = ({
    type,
    isDirty,
    paymentType,
    paymentId,
    isPaid = false,
}: {
    type: string;
    isDirty: boolean;
    paymentType?: string;
    itemData?: { id: string };
    isPaid?: boolean;
    paymentId: string;
}) => {
    const { cashierDetails } = usePage().props as unknown as {
        cashierDetails: { is_completed: boolean };
    };

    const toggleError = () => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This transaction is not yet paid!',
        });
    };

    return (
        <div className="d-flex justify-content-between m-4">
            {!cashierDetails.is_completed && isPaid && <CompleteCashier />}
            {cashierDetails.is_completed && isPaid && (
                <h5 className="text-danger">
                    Cashier Completed
                    <button
                        type="button"
                        className="tooltip-container"
                        data-title="This cashier is already completed."
                    >
                        <IconExclamationCircleFilled />
                    </button>
                </h5>
            )}
            {!isPaid && (
                <Button size="lg" type="button" onClick={() => toggleError()}>
                    <IconChecklist />
                    Complete Cashier
                </Button>
            )}
            <h5 className="text-danger">
                {isDirty && (
                    <>
                        Unsaved changes{' '}
                        <button
                            type="button"
                            className="tooltip-container"
                            data-title="Changes made arent saved unless the 'Save' button is clicked"
                        >
                            <IconExclamationCircleFilled />
                        </button>
                    </>
                )}
            </h5>
            {paymentType === 'Billing' && !isPaid && (
                <SendToBilling id={paymentId}/>
            )}
            {paymentType === 'Pharmacy' && !isPaid && (
                <SendToPharmacy id={paymentId}/>
            )}
        </div>
    );
};

export default SaveButton;
