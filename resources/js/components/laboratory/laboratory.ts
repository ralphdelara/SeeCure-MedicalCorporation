export interface LaboratoryDetailsFormProps {
    laboratory_test_ids: number[];
    has_laboratory: number;
}

export interface LaboratoryFormProps {
    data: LaboratoryDetailsFormProps;
    setData: (key: keyof LaboratoryDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}