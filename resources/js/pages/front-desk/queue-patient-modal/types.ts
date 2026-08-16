import { ConsultationDetailsFormProps } from '@/components/consultation/consultation';
import { SignsOrSymptomsDetailsFormProps } from '@/components/consultation/signs-or-symptoms';
import { VitalSignsDetailsFormProps } from '@/components/vital-signs/vital-signs';

export interface AddPatientFormTypes
    extends
        ConsultationDetailsFormProps,
        VitalSignsDetailsFormProps {
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

    philhealth_id: number | string;
}

export interface PassFormDataProps {
    data: AddPatientFormTypes;
    setData: (key: keyof AddPatientFormTypes, value: any) => void;
    errors?: Record<string, string>;
}
