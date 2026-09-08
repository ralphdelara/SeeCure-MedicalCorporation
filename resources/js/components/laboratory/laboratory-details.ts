import { AddOrUpdateLaboratoryDetailsFormProps } from "./new-laboratory";

export interface LaboratoryDetailsProps {
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

export interface LaboratoryDetailsTabProps {
    laboratoryDetails: AddOrUpdateLaboratoryDetailsFormProps & {
        id: string;
    };
}