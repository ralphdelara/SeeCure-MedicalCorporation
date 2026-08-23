import { Input } from '@/components/ui/input';
import { AddOrUpdatePatientFormProps } from './new-patient';
import AddressForm from '../address/form';
import Personal from './new-patient-personal';
import Contact from './new-patient-contact';

const NewPatientForm = ({ data, setData, errors = {} }: AddOrUpdatePatientFormProps) => {
    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">(*) Mandatory</div>
            <div className="row">
                <Personal data={data} setData={setData} errors={errors}/>
                <Contact data={data} setData={setData} errors={errors}/>
            </div>
        </section>
    );
};

export default NewPatientForm;
