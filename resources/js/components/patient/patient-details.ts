import { AddOrUpdatePatientDetailsFormProps } from "./new-patient";

export interface PatientDetailsProps {
    id: string;
    full_name?: string;
    age?: string;
    gender?: {
        name: string;
    };
    status?: {
        name: string;
    };
}

export interface PatientDetailsTabProps {
    patientDetails: AddOrUpdatePatientDetailsFormProps & {
        id: string;
    };
}