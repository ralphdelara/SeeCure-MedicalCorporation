import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import type { QueuePatientFormProps } from './types';
import SignsOrSymptomsForm from '@/components/consultation/signs-or-symptoms-form';
import VitalSignsForm from '@/components/vital-signs/vital-signs-form';
import FormHeader from '@/components/ui/form-header';

interface InertiaProps {
    doctors: Options[];
    relationshipOptions: Options[];
}

const ConsultationForm = ({ data, setData, errors = {} }: QueuePatientFormProps) => {
    const { doctors, relationshipOptions } = usePage().props as unknown as InertiaProps;

    return (
        <div>
            <div className="form-group">
                <FormHeader>Consultation</FormHeader>
                <div className="row">
                    <div className="col-md-6">
                        <Label htmlFor="guardian-name" className="form-label">
                            Guardian
                        </Label>
                        <Input
                            value={data.guardian_name}
                            onChange={(e) => setData('guardian_name', e.target.value)}
                            id="guardian-name"
                            type="text"
                            className="form-control"
                            placeholder="ex. Joy Cruz"
                            maxLength={50}
                        />
                    </div>
                    <div className="col-md-6">
                        <Label htmlFor="guardian-contact-number" className="form-label">
                            Contact
                        </Label>
                        <Input
                            value={data.guardian_contact_number}
                            onChange={(e) => setData('guardian_contact_number', e.target.value)}
                            id="guardian-contact-number"
                            type="text"
                            className="form-control"
                            placeholder="ex. 09xxxxxxxxx"
                            maxLength={50}
                        />
                    </div>
                    <div className="col-md-6">
                        <Label htmlFor="guardian-email" className="form-label">
                            Email
                        </Label>
                        <Input
                            value={data.guardian_email}
                            onChange={(e) => setData('guardian_email', e.target.value)}
                            id="guardian-email"
                            type="text"
                            className="form-control"
                            placeholder="ex. xxxxxxxxxxxx@gmail.com"
                            maxLength={100}
                        />
                    </div>
                    <div className="col-md-6">
                        <Label htmlFor="guardian-relationship" className="form-label">
                            Relationship
                        </Label>
                        <Select
                            value={data.guardian_relationship_id}
                            onChange={(e) => setData('guardian_relationship_id', e.target.value)}
                            options={relationshipOptions}
                            type="Relationship"
                            id="guardian-relationship"
                        />
                        <InputError message={errors.guardian_relationship_id} className="mt-2" />
                    </div>
                </div>
            </div>
            <div className="form-group">
                <Label htmlFor="doctor-id" className="form-label">
                    Doctor *
                </Label>
                <Select
                    value={data.doctor_id}
                    onChange={(e) => setData('doctor_id', e.target.value)}
                    options={doctors}
                    type="Doctor"
                    id="doctor-id"
                />
                <InputError message={errors.doctor_id} className="mt-2" />
            </div>
            <div className="form-group mb-3">
                <Label htmlFor="doctor-id" className="form-label">
                    Reason for Consult
                </Label>

                <Input
                    value={data.consult_reason}
                    onChange={(e) => setData('consult_reason', e.target.value)}
                    id="consult_reason"
                    type="text"
                    className="form-control"
                    placeholder="ex. Backache"
                    maxLength={100}
                />
                <InputError message={errors.consult_reason} className="mt-2" />
            </div>

            <SignsOrSymptomsForm data={data} setData={setData} errors={errors} checkboxDivSize={6} />
            <VitalSignsForm data={data} setData={setData} />
        </div>
    );
};

export default ConsultationForm;
