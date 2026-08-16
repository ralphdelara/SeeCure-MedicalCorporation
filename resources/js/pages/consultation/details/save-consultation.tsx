import ConfirmButton from '@/components/confirm-button';
import { Button } from '@/components/ui/button';
import { consultation } from '@/routes';
import { IconDeviceFloppy } from '@tabler/icons-react';

const SaveConsultation = () => {
    const markAsDone = () => {};

    return (
        <form onSubmit={markAsDone}>
            <ConfirmButton
                requestMethod="PATCH"
                url={''}
                msg={'This will mark the consulation as done and will start appearing in other departments'}
                title="Save Consultation"
                successTitle="Success!"
                successMsg="The consultation record has been saved."
                successUrl={consultation().url}
            >
                <IconDeviceFloppy/>
                Save Consultation
            </ConfirmButton>
        </form>
    );
};

export default SaveConsultation;
