import { completeLaboratory } from '@/actions/App/Http/Controllers/LaboratoryController';
import ConfirmButton from '@/components/confirm-button';
import { formatReceiptDateTime, isToday } from '@/lib/utils';
import { laboratoryList } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const CompleteLaboratory = () => {
    const { laboratoryDetails } = usePage().props as unknown as {
        laboratoryDetails: {
            id: string;
            moveToText: string;
            created_at: string;
        };
    };

    const redirectPending = isToday(new Date(formatReceiptDateTime(laboratoryDetails.created_at)))
        ? 'pending-today'
        : '';

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completeLaboratory(laboratoryDetails.id).url}
            msg={
                laboratoryDetails.moveToText !== 'Completed'
                    ? 'This will move the patient to "' + laboratoryDetails.moveToText + '" and the laboratory will be marked as completed!'
                    : 'This will complete the Patient Visit.'
            }
            title="Complete Laboratory"
            successTitle="Success!"
            successMsg="The laboratory record has been completed."
            successUrl={laboratoryList(redirectPending).url}
            size="lg"
        >
            <IconChecklist />
            Complete Laboratory
        </ConfirmButton>
    );
};

export default CompleteLaboratory;
