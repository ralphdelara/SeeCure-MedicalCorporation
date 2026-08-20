import type { Options } from '@/types/options';

export interface ConsultationList {
    id: string;
    patient_id: string;
    patient: any;
    status: any;
    doctor: {
        full_name: string;
        professions: {
            profession: {
                id: number;
                name: string;
                prefix: string;
                suffix: string;
            };
        }[];
    };
    created_by: any;
    signs_or_symptoms: {
        signs_or_symptom: Options;
    }[];
    types: {
        type: Options;
    }[];
    gender: Options;
    created_at: string;
}
