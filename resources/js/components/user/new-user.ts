import { AddressDetailsFormProps } from '../address/types';

export interface AddOrUpdateUserDetailsFormProps extends AddressDetailsFormProps {
    user_id: number | string;
    username: string;
    password: string;
    department_ids: number[];
    profession_ids: number[];
    specialty_ids: number[];
    position_ids: number[];
    license_no: string;
    ptr_no: string;
    date_hired: string;
    date_resigned: string;
    status: boolean;

    last_name: string;
    first_name: string;
    middle_name: string;
    date_of_birth: string;
    gender_id: number | string;
    photo: string;

    contact_number: string;
    email: string;
}

export interface AddOrUpdateUserFormProps {
    data: AddOrUpdateUserDetailsFormProps;
    setData: (key: keyof AddOrUpdateUserDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
