export interface AddOrUpdateInventoryDetailsFormProps {
    id?: number;
    name: string;
    inventory_category_id: number | string;
    inventory_unit_id: number | string;
    stock: number | string;
    cost_price: any;
    selling_price_vat_exclusive: any;
    selling_price_vat_inclusive: any;
    markup_amount: any;
    markup_percent: any;
    vat_percent: number | string;
    vat_amount: number | string;
    photo?: string;
}

export interface AddOrUpdateInventoryFormProps {
    data: AddOrUpdateInventoryDetailsFormProps;
    setData: (key: keyof AddOrUpdateInventoryDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
