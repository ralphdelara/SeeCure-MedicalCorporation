import { AddOrUpdatePaymentDetailsFormProps } from "./new-payment";

export interface PaymentDetailsProps {
    full_name?: string;
    age?: string;
    gender?: {
        name: string;
    };
    status?: {
        name: string;
    };
}

export interface PaymentDetailsTabProps {
    paymentDetails: AddOrUpdatePaymentDetailsFormProps & {
        id: string;
    };
}