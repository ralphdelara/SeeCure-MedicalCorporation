import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import type { PassFormDataProps } from './types';

const ExistingPatientForm = ({ /*data, setData,*/ errors = {} }: PassFormDataProps) => {
    //const searchPatient = () => {};

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">
                <label className="form-label" htmlFor="search-patient">
                    Search Patient *
                </label>
                <InputError message={errors.patient_id} className="mt-2" />
                <Input
                    id="search-patient"
                    type="text"
                    className="form-control"
                    placeholder="ex. Juan Cruz"
                />
            </div>
        </section>
    );
};

export default ExistingPatientForm;
