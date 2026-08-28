import { SignsOrSymptomsDetailsFormProps, SignsOrSymptomsFormProps } from "./signs-or-symptoms";

export interface ConsultationDetailsFormProps extends SignsOrSymptomsDetailsFormProps {
    guardian_name: string;
    guardian_contact_number: string;
    guardian_email: string;
    has_consultation: number;
    doctor_id: string | number;
}

export interface ConsultationFormProps {
    data: ConsultationDetailsFormProps;
    setData: (key: keyof ConsultationDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}