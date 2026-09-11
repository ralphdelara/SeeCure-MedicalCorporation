import { Button } from '@/components/ui/button';
import { IconDeviceFloppy, IconExclamationCircleFilled } from '@tabler/icons-react';
import CompleteCashier from './complete-cashier';
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
    const { cashierDetails } = usePage().props as unknown as {
        cashierDetails: { is_completed: boolean };
    };

    return (
        <div className="d-flex justify-content-between m-4">
            {!cashierDetails.is_completed && <CompleteCashier />}
            {cashierDetails.is_completed && (
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
            {!hideSaveButton ? (
                <Button size="lg" className="ms-3">
                    <i>
                        <IconDeviceFloppy className="me-1" />
                    </i>
                    Save {type}
                </Button>
            ) : (
                <div></div>
            )}
        </div>
    );
};

export default SaveButton;
