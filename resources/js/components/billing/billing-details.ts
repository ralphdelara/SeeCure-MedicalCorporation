import { AddOrUpdateBillingDetailsFormProps } from "./new-billing";

export interface BillingDetailsProps {
    id: string;
    full_name?: string;
    age?: string;
    gender?: {
        name: string;
    };
    status?: {
        name: string;
    };
}

export interface BillingDetailsTabProps {
    billingDetails: AddOrUpdateBillingDetailsFormProps & {
        id: string;
    };
}