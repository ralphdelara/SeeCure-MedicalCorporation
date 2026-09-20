import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Label } from '@/components/ui/label';
import type { Options } from '@/types/options';
import { ConsultationFormProps } from '@/components/consultation/consultation';
import { SignsOrSymptomsFormProps } from './signs-or-symptoms';

interface InertiaProps {
    signsOrSymptoms: Options[];
}

const SignsOrSymptomsForm = ({
    data,
    setData,
    errors = {},
    checkboxDivSize = 4,
}: SignsOrSymptomsFormProps) => {
    const { signsOrSymptoms } = usePage().props as unknown as InertiaProps;

    const updateSignsOrSymptoms = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('signs_or_symptoms_id', [
                ...data.signs_or_symptoms_id,
                parseInt(e.target.value),
            ]);
        } else {
            setData(
                'signs_or_symptoms_id',
                data.signs_or_symptoms_id.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group fs-4">
                <Label htmlFor="signsOrSymptoms" className="form-label">
                    <h5 className="fw-bolder">Signs / Symptoms</h5>
                </Label>
                <div className="row">
                    {signsOrSymptoms?.map((item, index) => (
                        <div
                            className={'col-md-' + checkboxDivSize}
                            key={'signsOrSymptoms-' + index}
                        >
                            <div className="form-check form-check-inline">
                                <input
                                    className="form-check-input success"
                                    type="checkbox"
                                    id={'signs-or-symptoms-' + index}
                                    value={item.id}
                                    onChange={(e) => updateSignsOrSymptoms(e)}
                                    name="signs-or-symptoms"
                                    checked={data.signs_or_symptoms_id.includes(item.id)}
                                />
                                <label
                                    className="form-check-label"
                                    htmlFor={'signs-or-symptoms-' + index}
                                >
                                    {item.name}
                                </label>
                            </div>
                        </div>
                    ))}
                    <InputError message={errors.signs_or_symptoms_id} className="mt-2" />
                </div>
            </div>
        </section>
    );
};

export default SignsOrSymptomsForm;
