import { Button } from '@/components/ui/button';
import {
    IconDeviceFloppy,
    IconExclamationCircle,
    IconExclamationCircleFilled,
} from '@tabler/icons-react';

const SaveCompanyProfile = ({ isDirty, className }: { isDirty: boolean; className: string }) => {
    return (
        <div className="d-flex justify-content-between">
            <h5 className={'text-danger ' + className}>
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
            <Button size="lg" className={className}>
                <i>
                    <IconDeviceFloppy className="me-1" />
                </i>{' '}
                Save Company Profile
            </Button>
        </div>
    );
};

export default SaveCompanyProfile;
