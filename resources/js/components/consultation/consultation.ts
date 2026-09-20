import { SignsOrSymptomsDetailsFormProps, SignsOrSymptomsFormProps } from './signs-or-symptoms';

export interface ConsultationDetailsFormProps extends SignsOrSymptomsDetailsFormProps {
    guardian_name: string;
    guardian_contact_number: string;
    guardian_email: string;
    guardian_relationship_id: string;
    doctor_id: string | number;
    has_consultation: number;
    consult_reason: string;
}

export interface ConsultationFormProps {
    data: ConsultationDetailsFormProps;
    setData: (key: keyof ConsultationDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
