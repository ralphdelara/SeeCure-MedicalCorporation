import { AddressDetailsFormProps } from "../address/types";

export interface AddOrUpdatePatientDetailsFormProps extends AddressDetailsFormProps {
    patient_id: string;
    last_name: string;
    first_name: string;
    middle_name?: string;
    patient_suffix_id?: number | string;
    date_of_birth?: string;
    age?: string;
    contact_number1?: string;
    contact_number2?: string;
    email?: string;
    occupation?: string;

    gender_id?: number | string;
    civil_status_id?: number | string;
    nationality_id?: number | string;

    photo?: string;

    philhealth_id: number | string;
}

export interface AddOrUpdatePatientFormProps {
    data: AddOrUpdatePatientDetailsFormProps;
    setData: (key: keyof AddOrUpdatePatientDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
