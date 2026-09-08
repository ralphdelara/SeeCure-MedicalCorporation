import { Input } from '@/components/ui/input';
import type { Options } from '@/types/options';
import { AddOrUpdateLaboratoryFormProps } from './new-laboratory';
import AddressForm from '../address/form';

const Contact = ({ data, setData, errors = {} }: AddOrUpdateLaboratoryFormProps) => {
    return (
        <>
            <h5 className="fw-semibold mt-3">Contact Details</h5>
            <div className="row">
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="contact-number1">
                            Contact Number 1
                        </label>

                        <Input
                            value={data.contact_number1}
                            onChange={(e) => setData('contact_number1', e.target.value)}
                            id="contact-number1"
                            type="text"
                            className="form-control"
                            placeholder="ex. 09xxxxxxxxx"
                            maxLength={50}
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="contact-number2">
                            Contact Number 2
                        </label>

                        <Input
                            value={data.contact_number2}
                            onChange={(e) => setData('contact_number2', e.target.value)}
                            id="contact-number2"
                            type="text"
                            className="form-control"
                            placeholder="ex. 09xxxxxxxxx"
                            maxLength={50}
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="email">
                            Email
                        </label>

                        <Input
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            id="email"
                            type="email"
                            placeholder="ex. xxxxxx@gmail.com"
                            maxLength={50}
                        />
                    </div>
                </div>
                <AddressForm data={data} setData={setData}/>
            </div>
        </>
    );
};

export default Contact;