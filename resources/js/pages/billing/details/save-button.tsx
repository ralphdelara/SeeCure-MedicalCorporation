import { Button } from '@/components/ui/button';
import { IconDeviceFloppy, IconExclamationCircleFilled } from '@tabler/icons-react';
import ConfirmBilling from './complete-billing';
import { usePage } from '@inertiajs/react';

const SaveButton = ({
    type,
    isDirty,
    hideSaveButton = false,
}: {
    type: string;
    isDirty: boolean;
    hideSaveButton?: boolean;
}) => {
    const { billingDetails } = usePage().props as unknown as {
        billingDetails: { is_completed: boolean };
    };

    return (
        <div className="d-flex justify-content-between m-4">
            {!billingDetails.is_completed && <ConfirmBilling />}
            {billingDetails.is_completed && (
                <h5 className="text-danger">
                    Billing Completed
                    <button
                        type="button"
                        className="tooltip-container"
                        data-title="This billing is already completed."
                    >
                        <IconExclamationCircleFilled />
                    </button>
                </h5>
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
            {!hideSaveButton && (
                <Button size="lg" className="ms-3">
                    <i>
                        <IconDeviceFloppy className="me-1" />
                    </i>
                    Save {type}
                </Button>
            )}
        </div>
    );
};

export default SaveButton;
