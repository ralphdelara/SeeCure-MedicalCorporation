import type { Options } from '@/types/options';
import { VisitPatientInfo } from './visit';

export interface ConsultationList extends VisitPatientInfo {
    id: string;
    patient_id: string;
    is_completed: number;
    doctor: {
        full_name: string;
        specialties: Options[];
    };
    created_by: any;
    signs_or_symptoms: Options[];
    patient_vital_sign: {
        id: string;
        vital_sign: Options;
        vital_sign_field: {
            name: string;
            unit: string;
        };
        value: string;
    }[];
    types: {
        type: Options;
    }[];
    gender: Options;
    guardian_name: string;
    guardian_contact_number: string;
    guardian_email: string;
    guardian_relationship: Options;
    created_at: string;
    last_modified_by: {
        full_name: string;
    };
    updated_at: string;
}
