import type { Options } from '../../types/options';

interface VitalSignFields extends Options {
    unit: string;
}

export interface VitalSigns extends Options {
    fields: VitalSignFields[];
}

export interface VitalSignsDetailsFormProps {
    vital_signs: Record<string, Record<string, string | number>>;
}

export interface VitalSignsFormProps {
    data: VitalSignsDetailsFormProps;
    setData: (key: keyof VitalSignsDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}