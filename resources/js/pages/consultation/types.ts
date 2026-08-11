import type { Options } from '@/types/options';

export interface ConsultationList {
    id: number;
    patient: any;
    status: any;
    doctor: any;
    created_by: any;
    signs_or_symptoms: {
        signs_or_symptom: Options;
    }[];
    types: {
        type: Options;
    }[];
}
