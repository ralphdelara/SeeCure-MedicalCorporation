import { Options } from "@/types/options";

export interface PaymentTableList {
    id: string;
    patient: {
        id: string;
        full_name: string;
        gender: {
            name: string;
        };
    };
    details: {
        name: string;
    }[];
    is_completed: boolean;
    created_by: {
        full_name: string;
    };
    created_at: string;
    last_modified_by: {
        full_name: string;
    };
    updated_at: string;
}