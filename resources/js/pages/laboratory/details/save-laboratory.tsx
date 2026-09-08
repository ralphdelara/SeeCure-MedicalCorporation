import { completeLaboratory } from '@/actions/App/Http/Controllers/LaboratoryController';
import ConfirmButton from '@/components/confirm-button';
import { laboratory } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';

const SaveLaboratory = () => {
    const { laboratoryDetails } = usePage().props as unknown as {
        laboratoryDetails: {
            id: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeLaboratory(laboratoryDetails.id).url}
            msg={
                'This will move the patient to "Radiology" or "Consultation" and the laboratory will be marked as completed!'
            }
            title="Save Laboratory"
            successTitle="Success!"
            successMsg="The laboratory record has been saved."
            successUrl={laboratory().url}
            size="lg"
        >
            <IconDeviceFloppy />
            Save Laboratory
        </ConfirmButton>
    );
};

export default SaveLaboratory;
