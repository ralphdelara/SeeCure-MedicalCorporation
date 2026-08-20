export interface PatientTableList {
    id: number;
    full_name: string;
    gender: {
        name: string;
    };
    date_of_birth: string;
    age: string;
    contact_number: string;
    email: string;
    status: {
        name: string;
    };
}