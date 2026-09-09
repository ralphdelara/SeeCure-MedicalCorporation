import { Button } from '@/components/ui/button';
import { IconDeviceFloppy, IconExclamationCircleFilled } from '@tabler/icons-react';
import SaveBilling from './save-billing';

const SaveButton = ({ type, isDirty }: { type: string; isDirty: boolean }) => {
    return (
        <div className="d-flex justify-content-between m-4">
            <SaveBilling />
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
