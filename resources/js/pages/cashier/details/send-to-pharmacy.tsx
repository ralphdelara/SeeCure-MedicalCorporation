import ConfirmButton from '@/components/confirm-button';
import { cashier } from '@/routes';
import { sendBackToPharmacy } from '@/routes/cashier/details';
import { IconPrescription } from '@tabler/icons-react';

const SendToPharmacy = ({ id }: { id: string }) => {
    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={sendBackToPharmacy(id).url}
            msg="This will move the patient back to Pharmacy and the cashier record will be removed"
            title="Send to Pharmacy"
            successTitle="Success!"
            successMsg="The cashier record has been removed."
            successUrl={cashier().url}
            size="lg"
        >
            <IconPrescription /> Send to Pharmacy
        </ConfirmButton>
    );
};

export default SendToPharmacy;
