import { ConsultationDetailsFormProps } from '@/components/consultation/consultation';
import { AddOrUpdateLaboratoryDetailsFormProps } from '@/components/laboratory/new-laboratory';
import { AddOrUpdatePatientDetailsFormProps } from '@/components/patient/new-patient';
import { RadiologyDetailsFormProps } from '@/components/radiology/radiology';
import { VitalSignsDetailsFormProps } from '@/components/vital-signs/vital-signs';

export interface QueuePatientDetailsFormProps
    extends
        AddOrUpdatePatientDetailsFormProps,
        ConsultationDetailsFormProps,
        AddOrUpdateLaboratoryDetailsFormProps,
        RadiologyDetailsFormProps,
        VitalSignsDetailsFormProps {
    form_type: string;
    is_emergency: number;
    is_walk_in: number;
    has_laboratory: number;
    priority_type_ids: number[];
}

export interface QueuePatientFormProps {
    data: QueuePatientDetailsFormProps;
    setData: (key: keyof QueuePatientDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
