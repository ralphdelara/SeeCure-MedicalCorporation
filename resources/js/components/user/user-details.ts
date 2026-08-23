import { AddOrUpdateUserDetailsFormProps } from "./new-user";

export interface UserDetailsProps {
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

export interface UserDetailsTabProps {
    userDetails: AddOrUpdateUserDetailsFormProps & {
        id: string;
        professions: number[];
        specialties: number[];
    };
}