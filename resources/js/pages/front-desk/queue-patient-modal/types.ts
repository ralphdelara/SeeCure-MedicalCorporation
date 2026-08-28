import { ConsultationDetailsFormProps } from '@/components/consultation/consultation';
import { LaboratoryDetailsFormProps } from '@/components/laboratory/laboratory';
import { AddOrUpdatePatientDetailsFormProps } from '@/components/patient/new-patient';
import { RadiologyDetailsFormProps } from '@/components/radiology/radiology';
import { VitalSignsDetailsFormProps } from '@/components/vital-signs/vital-signs';

export interface QueuePatientDetailsFormProps
    extends
        AddOrUpdatePatientDetailsFormProps,
        ConsultationDetailsFormProps,
        LaboratoryDetailsFormProps,
        RadiologyDetailsFormProps,
        VitalSignsDetailsFormProps {
    form_type: string;
}

export interface QueuePatientFormProps {
    data: QueuePatientDetailsFormProps;
    setData: (key: keyof QueuePatientDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
