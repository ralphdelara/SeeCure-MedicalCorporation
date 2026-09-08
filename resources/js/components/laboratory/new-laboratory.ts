export interface AddOrUpdateLaboratoryDetailsFormProps {
    laboratory_id: string;
    laboratory_package_id: string;
    other_test_ids: string[];
}

export interface AddOrUpdateLaboratoryFormProps {
    data: AddOrUpdateLaboratoryDetailsFormProps;
    setData: (key: keyof AddOrUpdateLaboratoryDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
