import { Button } from '@/components/ui/button';
import CompleteConsultation from './complete-consultation';
import {
    IconDeviceFloppy,
    IconExclamationCircle,
    IconExclamationCircleFilled,
} from '@tabler/icons-react';
import { usePage } from '@inertiajs/react';

const SaveButton = ({ type, isDirty }: { type: string; isDirty: boolean }) => {
    const { consultationDetails } = usePage().props as unknown as {
        consultationDetails: { is_completed: boolean };
    };

    return (
        <div className="d-flex justify-content-between mt-2 mb-2">
            {!consultationDetails.is_completed && <CompleteConsultation />}
            {consultationDetails.is_completed && (
                <h5 className="text-danger">
                    Consultation Completed
                    <button
                        type="button"
                        className="tooltip-container"
                        data-title="This consultation is already completed."
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
            <Button size="lg" className="ms-3">
                <i>
                    <IconDeviceFloppy className="me-1" />
                </i>
                Save {type}
            </Button>
        </div>
    );
};

export default SaveButton;
