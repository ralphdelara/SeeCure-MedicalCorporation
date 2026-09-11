import { completeConsultation } from '@/actions/App/Http/Controllers/ConsultationController';
import ConfirmButton from '@/components/confirm-button';
import { consultations } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const CompleteConsultation = () => {
    const { consultationDetails } = usePage().props as unknown as {
        consultationDetails: {
            id: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeConsultation(consultationDetails.id).url}
            msg={
                'This will move the patient to "Billing" and the consultation will be marked as completed!'
            }
            title="Complete Consultation"
            successTitle="Success!"
            successMsg="The consultation record has been completed."
            successUrl={consultations().url}
            size="lg"
        >
            <IconChecklist />
            Complete Consultation
        </ConfirmButton>
    );
};

export default CompleteConsultation;
