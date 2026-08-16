import { usePage } from '@inertiajs/react';
import type { PassFormDataProps } from './types';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';
import InputError from '@/components/input-error';

interface InertiaProps {
    laboratoryOptions: Options[];
}

const LaboratoryForm = ({ data, setData, errors = {} }: PassFormDataProps) => {
    const { laboratoryOptions } = usePage().props as unknown as InertiaProps;

    const updateLaboratoryTests = (e: React.ChangeEvent<HTMLInputElement>) => {
        
    }

    return (
<section role="tabpanel" className="body current">
            <div className="form-group">
                <Label htmlFor="medicalServices" className="form-label">
                    Laboratory Tests *
                </Label>
                <div className="row">
                    {laboratoryOptions.map((item, index) => (
                        <div className="col-md-4" key={'medicalService-' + index}>
                            <div className="form-check form-check-inline">
                                <input
                                    className="form-check-input success"
                                    type="checkbox"
                                    value={item.id}
                                    onChange={(e) => updateLaboratoryTests(e)}
                                    checked={data[item.id as keyof AddPatientFormTypes] === 1}
                                />
                                <label className="form-check-label" htmlFor={item.id}>
                                    {item.name}
                                </label>
                            </div>
                        </div>
                    ))}
                    <InputError message={errors.has_consultation} className="mt-2" />
                </div>
            </div>
            </section>
    );
}

export default LaboratoryForm;