import type { Options } from './options';

interface VitalSignFields extends Options {
    unit: string;
}

export interface VitalSigns extends Options {
    fields: VitalSignFields[];
}
