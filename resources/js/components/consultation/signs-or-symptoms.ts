export interface SignsOrSymptomsDetailsFormProps {
    signs_or_symptoms_id: number[];
}

export interface SignsOrSymptomsFormProps {
    data: SignsOrSymptomsDetailsFormProps;
    setData: (key: keyof SignsOrSymptomsDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
    checkboxDivSize?: number;
}
