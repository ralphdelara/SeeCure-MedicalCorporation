import { Button } from '@/components/ui/button';
import { IconDeviceFloppy, IconExclamationCircle, IconExclamationCircleFilled } from '@tabler/icons-react';

const SaveButton = ({ type, isDirty }: { type: string; isDirty: boolean }) => {
    return (
        <div className="d-flex justify-content-between mt-2">
            <h5 className="text-danger">
                {isDirty && (
                    <>
                        Unsaved changes{' '}
                        <button
                            className="tooltip-container"
                            data-title="Changes made arent saved unless the 'Save' button is clicked"
                        >
                            <IconExclamationCircleFilled />
                        </button>
                    </>
                )}
            </h5>
            <Button size="lg">
                <i>
                    <IconDeviceFloppy className="me-1" />
                </i>
                Save {type}
            </Button>
        </div>
    );
};

export default SaveButton;
