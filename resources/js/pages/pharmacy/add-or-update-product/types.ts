import { Options } from '@/types/options';
import { PageLinks, Pages } from '@/types/pagination';

export interface ProductList {
    id: number;
    name: string;
    category: Options;
    unit: Options;
    stock: string;
    cost_price: string;
    markup_amount: string;
    markup_percent: string;
    vat_percent: string;
    vat_amount: string;
    selling_price_vat_exclusive: string;
    selling_price_vat_inclusive: string;
    photo?: string;
    created_by: string;
}

export interface AddProductForm {
    id?: number;
    name: string;
    product_category_id: number | string;
    product_unit_id: number | string;
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

export interface PassFormDataProps {
    data: AddProductForm;
    setData: (key: keyof AddProductForm, value: any) => void;
    errors?: Record<string, string>;
}
