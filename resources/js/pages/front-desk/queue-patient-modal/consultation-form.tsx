import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import type { AddPatientFormTypes, PassFormDataProps } from './types';

interface InertiaProps {
    doctors: Options[];
}

const ConsultationForm = ({ data, setData, errors = {} }: PassFormDataProps) => {
    const { doctors } = usePage().props as unknown as InertiaProps;
    const medicalServices = [
        {name: 'Consultation', id: 'has_consultation', value: 1},
        {name: 'Laboratory', id: 'has_laboratory', value: 1},
    ];
    const updateMedicalServices = (e: React.ChangeEvent<HTMLInputElement>) => {
        const checkboxId = e.currentTarget.id as keyof AddPatientFormTypes;
        const isChecked = (e.target as HTMLInputElement).checked;
console.log(checkboxId, isChecked);
        setData(checkboxId, isChecked ? 1 : 0);
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">
                <Label htmlFor="medicalServices" className="form-label">
                    Medical Services *
                </Label>
                <div className="row">
                    {medicalServices.map((item, index) => (
                        <div className="col-md-4" key={'medicalService-' + index}>
                            <div className="form-check form-check-inline">
                                <input
                                    className="form-check-input success"
                                    type="checkbox"
                                    id={item.id}
                                    value={item.value}
                                    onChange={(e) => updateMedicalServices(e)}
                                    name={item.id}
                                    checked={data[item.id as keyof AddPatientFormTypes] === 1}
                                />
                                <label
                                    className="form-check-label"
                                    htmlFor={item.id}
                                >
                                    {item.name}
                                </label>
                            </div>
                        </div>
                    ))}
                    <InputError message={errors.has_consultation} className="mt-2" />
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
