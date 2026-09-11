export interface AddOrUpdatePaymentDetailsFormProps {
    payment_id: string;
}

export interface AddOrUpdatePaymentFormProps {
    data: AddOrUpdatePaymentDetailsFormProps;
    setData: (key: keyof AddOrUpdatePaymentDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
