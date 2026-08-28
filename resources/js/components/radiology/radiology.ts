export interface RadiologyDetailsFormProps {
    radiology_test_ids: number[];
    has_radiology: number;
}

export interface RadiologyFormProps {
    data: RadiologyDetailsFormProps;
    setData: (key: keyof RadiologyDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}