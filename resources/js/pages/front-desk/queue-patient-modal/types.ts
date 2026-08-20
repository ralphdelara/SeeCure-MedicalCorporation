import { ConsultationDetailsFormProps } from '@/components/consultation/consultation';
import { AddOrUpdatePatientDetailsFormProps } from '@/components/patient/new-patient';
import { VitalSignsDetailsFormProps } from '@/components/vital-signs/vital-signs';

export interface QueuePatientDetailsFormProps
    extends
        AddOrUpdatePatientDetailsFormProps,
        ConsultationDetailsFormProps,
        VitalSignsDetailsFormProps {
    form_type: string;
}

export interface QueuePatientFormProps {
    data: QueuePatientDetailsFormProps;
    setData: (key: keyof QueuePatientDetailsFormProps, value: any) => void;
    errors?: Record<string, string>;
}
