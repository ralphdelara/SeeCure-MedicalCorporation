import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import type { PassFormDataProps } from './types';

interface InertiaProps {
    consultationTypes: Options[];
    doctors: Options[];
}

const ConsultationForm = ({ data, setData, errors = {} }: PassFormDataProps) => {
    const { consultationTypes, doctors } = usePage().props as unknown as InertiaProps;

    const updateConsultationTypes = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('consultation_types_id', [
                ...data.consultation_types_id,
                parseInt(e.target.value),
            ]);
        } else {
            setData(
                'consultation_types_id',
                data.consultation_types_id.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">
                <Label htmlFor="medicalServices" className="form-label">
                    Medical Services *
                </Label>
                <div className="row">
                    {consultationTypes.map((item, index) => (
                        <div className="col-md-4" key={'signsOrSymptoms-' + index}>
                            <div className="form-check form-check-inline">
                                <input
                                    className="form-check-input success"
                                    type="checkbox"
                                    id={'consultation_types-' + index}
                                    value={item.id}
                                    onChange={(e) => updateConsultationTypes(e)}
                                    name="consultation_types"
                                    checked={data.consultation_types_id.includes(item.id)}
                                />
                                <label
                                    className="form-check-label"
                                    htmlFor={'consultation_types-' + index}
                                >
                                    {item.name}
                                </label>
                            </div>
                        </div>
                    ))}
                    <InputError message={errors.consultation_types_id} className="mt-2" />
                </div>
            </div>
            <div className="form-group">
                <div className="row">
                    <div className="col-md-4">
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
                    <div className="col-md-4">
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
                    <div className="col-md-4">
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
                </div>
            </div>
            <div className="form-group">
                <Label htmlFor="doctor-id" className="form-label">
                    Doctor *
                </Label>
                <Select
                    value={data.doctor_id}
                    onChange={(e) => setData('doctor_id', parseInt(e.target.value))}
                    options={doctors}
                    type="Doctor"
                    id="doctor-id"
                />
                <InputError message={errors.doctor_id} className="mt-2" />
            </div>
        </section>
    );
};

export default ConsultationForm;
