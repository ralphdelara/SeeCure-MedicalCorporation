import { Options } from '@/types/options';

export interface UserTableList {
    id: string;
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
    departments: Options[];
    positions: Options[];
    professions: Options[];
    specialties: Options[];
    roles: Options[];
    created_by?: {
        id: string;
        full_name: string;
    };
    created_at: string;
    is_bot: boolean;
    license_no: string;
    ptr_no: string;
    date_hired: string;
    date_resigned: string;
    full_address: string;
}
