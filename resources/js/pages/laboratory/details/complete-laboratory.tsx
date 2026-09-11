import { completeLaboratory } from '@/actions/App/Http/Controllers/LaboratoryController';
import ConfirmButton from '@/components/confirm-button';
import { laboratory } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const CompleteLaboratory = () => {
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
            title="Complete Laboratory"
            successTitle="Success!"
            successMsg="The laboratory record has been completed."
            successUrl={laboratory().url}
            size="lg"
        >
            <IconChecklist />
            Complete Laboratory
        </ConfirmButton>
    );
};

export default CompleteLaboratory;
