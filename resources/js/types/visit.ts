import type { Options } from '@/types/options';

export interface VisitPatientInfo {
    visit: {
        patient: {
            id: string;
            full_name: string;
            gender: {
                id: string;
                name: string;
            };
        };
    };
}
