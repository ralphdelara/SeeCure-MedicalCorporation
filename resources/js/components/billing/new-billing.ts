export interface AddOrUpdateBillingDetailsFormProps {
    billing_id: string;
}

export interface AddOrUpdateBillingFormProps {
    data: AddOrUpdateBillingDetailsFormProps;
    setData: (key: keyof AddOrUpdateBillingDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
