import { IconExclamationCircleFilled } from '@tabler/icons-react';

const UnsavedWarning = () => {
    return (
        <h5 className="text-danger">
            Unsaved changes{' '}
            <button
                className="tooltip-container"
                data-title="Changes made arent saved unless the 'Save' button is clicked"
            >
                <IconExclamationCircleFilled />
            </button>
        </h5>
    );
};

export default UnsavedWarning;
