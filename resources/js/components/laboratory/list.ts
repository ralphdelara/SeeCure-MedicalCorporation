import { Options } from "@/types/options";

export interface LaboratoryTableList {
    id: string;
    patient: {
        id: string;
        full_name: string;
        gender: {
            name: string;
        };
    };
    package: {
        name: string;
    };
    test: {
        id: string;
        name: string;
        fields: {
            id: string;
            name: string;
            value: string;
            unit: string;
        }[];
        price: string;
        remarks: string;
    }[];
    consultation_id: string;
    test_data: {
        type: {name: string};
        test: {name: string};
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