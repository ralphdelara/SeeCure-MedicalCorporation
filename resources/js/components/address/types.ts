import { Options } from "@/types/options";

export interface AddressDetailsFormProps {
    province_id: string;
    city_id: string;
    barangay_id: string;
    house_no: string;
    street: string;
}

export interface AddressFormProps {
    data: AddressDetailsFormProps;
    setData: (key: keyof AddressDetailsFormProps, value: any) => void;
}