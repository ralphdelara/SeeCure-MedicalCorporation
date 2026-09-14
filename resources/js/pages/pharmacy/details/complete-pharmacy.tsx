import { completePharmacy } from '@/actions/App/Http/Controllers/PharmacyController';
import ConfirmButton from '@/components/confirm-button';
import { pharmacy } from '@/routes';
import { usePage } from '@inertiajs/react';
import { IconChecklist } from '@tabler/icons-react';

const CompletePharmacy = () => {
    const { pharmacyDetails } = usePage().props as unknown as {
        pharmacyDetails: {
            id: string;
            moveToText: string;
        };
    };

    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={completePharmacy(pharmacyDetails.id).url}
            msg={
                'This will move the patient to "' + pharmacyDetails.moveToText + '" and the pharmacy will be marked as completed!'
            }
            title="Complete Pharmacy"
            successTitle="Success!"
            successMsg="The pharmacy record has been completed."
            successUrl={pharmacy().url}
            size="lg"
        >
            <IconChecklist />
            Complete Pharmacy
        </ConfirmButton>
    );
};

export default CompletePharmacy;
