import { Input } from '@/components/ui/input';
import type { Options } from '@/types/options';
import { AddOrUpdateUserFormProps } from './new-user';
import AddressForm from '../address/form';

const Contact = ({ data, setData, errors = {} }: AddOrUpdateUserFormProps) => {
    return (
        <>
            <h5 className="fw-semibold mt-3">Contact Details</h5>
            <div className="row">
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="contact-number">
                            Contact Number
                        </label>

                        <Input
                            value={data.contact_number}
                            onChange={(e) => setData('contact_number', e.target.value)}
                            id="contact-number"
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