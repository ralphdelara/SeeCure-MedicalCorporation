import { AddOrUpdateInventoryDetailsFormProps } from "./new-inventory";

export interface InventoryDetailsProps {
    id: string;
    name: string;
    stock: string;
    category: {
        name: string;
    };
    unit: {
        name: string;
    };
}

export interface InventoryDetailsTabProps {
    inventoryDetails: AddOrUpdateInventoryDetailsFormProps & {
        id: string;
    };
}