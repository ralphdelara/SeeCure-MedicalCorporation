export interface AddPatientFormTypes {
    form_type: string;
    patient_id: number | string;
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

    house_no?: string;
    street?: string;
    barangay_id?: string;
    city_id?: number | string;
    province_id?: number | string;

    photo?: string;
    consultation_types_id: number[];
    signs_or_symptoms_id: number[];
    vital_signs: Record<string, Record<string, string | number>>;

    guardian_name: string;
    guardian_contact_number: string;
    guardian_email: string;
    doctor_id: number | string;

    philhealth_id: number | string;
}

export interface PassFormDataProps {
    data: AddPatientFormTypes;
    setData: (key: keyof AddPatientFormTypes, value: any) => void;
    errors?: Record<string, string>;
}
