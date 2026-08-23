import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useState } from 'react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { barangayList } from '@/routes';
import type { Options } from '@/types/options';
import { AddOrUpdateUserFormProps } from './new-user';

interface InertiaProps {
    userFormOptions: {
        provinceOptions: Options[];
        cityOptions: Options[];
    };
}

const Contact = ({ data, setData, errors = {} }: AddOrUpdateUserFormProps) => {
    const { userFormOptions } = usePage().props as unknown as InertiaProps;
    const { provinceOptions, cityOptions } = userFormOptions;
    const [barangayOptions, setBarangayOptions] = useState([]);

    const getBarangay = async (cityId: number) => {
        await axios.get(barangayList({ cityId: cityId }).url).then((res) => {
            setBarangayOptions(res.data);
        });
    };

    const toggleCity = (value: number) => {
        setData('city_id', value);
        getBarangay(value);
    };
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
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="house-no">
                            House No
                        </label>

                        <Input
                            value={data.house_no}
                            onChange={(e) => setData('house_no', e.target.value)}
                            id="house-no"
                            type="text"
                            placeholder="ex. 123"
                            maxLength={5}
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="street">
                            Street
                        </label>

                        <Input
                            value={data.street}
                            onChange={(e) => setData('street', e.target.value)}
                            id="street"
                            type="text"
                            placeholder="ex. Street A"
                            maxLength={50}
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="province">
                            Province
                        </label>

                        <Select
                            value={data.province_id}
                            onChange={(e) => setData('province_id', parseInt(e.target.value))}
                            options={provinceOptions}
                            type="Province"
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="city">
                            Town/City
                        </label>

                        <Select
                            value={data.city_id}
                            onChange={(e) => toggleCity(parseInt(e.target.value))}
                            options={cityOptions}
                            type="City"
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="barangay">
                            Barangay
                        </label>

                        <Select
                            value={data.barangay_id}
                            onChange={(e) => setData('barangay_id', e.target.value)}
                            options={barangayOptions}
                            type="Barangay"
                        />
                    </div>
                </div>
            </div>
        </>
    );
};

export default Contact;