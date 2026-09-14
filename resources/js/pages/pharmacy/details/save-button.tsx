import { Button } from '@/components/ui/button';
import { IconChecklist, IconDeviceFloppy, IconExclamationCircleFilled } from '@tabler/icons-react';
import CompletePharmacy from './complete-pharmacy';
import { usePage } from '@inertiajs/react';
import Swal from 'sweetalert2';

const SaveButton = ({
    type,
    isDirty,
    hideSaveButton = false,
}: {
    type: string;
    isDirty: boolean;
    hideSaveButton?: boolean;
}) => {
    const { pharmacyDetails } = usePage().props as unknown as {
        pharmacyDetails: { is_completed: boolean };
    };

    return (
        <div className="d-flex justify-content-between m-4">
            {!pharmacyDetails.is_completed && <CompletePharmacy />}
            {pharmacyDetails.is_completed && (
                <h5 className="text-danger">
                    Pharmacy Completed
                    <button
                        type="button"
                        className="tooltip-container"
                        data-title="This pharmacy is already completed."
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
