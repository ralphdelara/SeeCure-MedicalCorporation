import { Button } from '@/components/ui/button';
import {
    IconDeviceFloppy,
    IconExclamationCircle,
    IconExclamationCircleFilled,
} from '@tabler/icons-react';
import CompleteLaboratory from './complete-laboratory';
import { usePage } from '@inertiajs/react';

const SaveButton = ({ type, isDirty }: { type: string; isDirty: boolean }) => {
    const { laboratoryDetails } = usePage().props as unknown as {
        laboratoryDetails: { is_completed: boolean };
    };

    return (
        <div className="d-flex justify-content-between m-4">
            {!laboratoryDetails.is_completed && <CompleteLaboratory />}
            {laboratoryDetails.is_completed && (
                <h5 className="text-danger">
                    Laboratory Completed
                    <button
                        type="button"
                        className="tooltip-container"
                        data-title="This laboratory is already completed."
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
