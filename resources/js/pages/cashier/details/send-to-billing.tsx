import ConfirmButton from '@/components/confirm-button';
import { cashier } from '@/routes';
import { sendBackToBilling } from '@/routes/cashier/details';
import { IconBuildingBank } from '@tabler/icons-react';

const SendToBilling = ({ id }: { id: string }) => {
    return (
        <ConfirmButton
            requestMethod="PATCH"
            url={sendBackToBilling(id).url}
            msg="This will move the patient back to Billing and the cashier record will be removed"
            title="Send to Billing"
            successTitle="Success!"
            successMsg="The cashier record has been removed."
            successUrl={cashier().url}
            size="lg"
        >
            <IconBuildingBank /> Send to Billing
        </ConfirmButton>
    );
};

export default SendToBilling;
