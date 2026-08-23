import { Options } from "@/types/options";

export interface PatientTableList {
    id: number;
    full_name: string;
    gender: {
        name: string;
    };
    date_of_birth: string;
    age: string;
    age_computed: string;
    contact_number1: string;
    contact_number2: string;
    email: string;
    status: {
        name: string;
    };
    civil_status: Options;
    nationality: Options;
    occupation: string;
    philhealth_id: string;
}