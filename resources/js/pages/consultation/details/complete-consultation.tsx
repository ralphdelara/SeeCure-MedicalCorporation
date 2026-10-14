import { completeConsultation } from '@/actions/App/Http/Controllers/ConsultationController';
import ConfirmButton from '@/components/confirm-button';
import { consultations } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist, IconExclamationCircleFilled } from '@tabler/icons-react';

const CompleteConsultation = () => {
    const { consultationDetails } = usePage().props as unknown as {
        consultationDetails: {
            id: string;
            is_completed: boolean;
        };
    };

    return (
        <>
            {!consultationDetails.is_completed && (
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
            )}
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
        </>
    );
};

export default CompleteConsultation;
