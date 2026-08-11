import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useState } from 'react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { getExactAge } from '@/lib/utils';
import { barangayList } from '@/routes';
import type { Options } from '@/types/options';
import type { PassFormDataProps } from './types';

interface InertiaProps {
    genderOptions: Options[];
    civilStatusOptions: Options[];
    nationalityOptions: Options[];
    suffixOptions: Options[];
    provinceOptions: Options[];
    cityOptions: Options[];
}

const NewPatientForm = ({ data, setData, errors = {} }: PassFormDataProps) => {
    const {
        genderOptions,
        civilStatusOptions,
        nationalityOptions,
        suffixOptions,
        provinceOptions,
        cityOptions,
    } = usePage().props as unknown as InertiaProps;

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

    const computeAge = (e: React.ChangeEvent<HTMLInputElement>) => {
        setData('date_of_birth', e.target.value);
        const currentDate = new Date().toISOString().split('T')[0];
        const { years, months, days } = getExactAge(e.target.value, currentDate);

        if (years < 0) {
            setData('age', 0);
        } else {
            setData('age', years + 'y ' + months + 'm ' + days + 'd');
        }
    };

    const inputAge = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (data.date_of_birth === '') {
            setData('age', parseInt(e.target.value));
        }
    };

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">(*) Mandatory</div>
            <div className="row">
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="last-name">
                            Last Name *
                        </label>

                        <Input
                            value={data.last_name}
                            onChange={(e) => setData('last_name', e.target.value)}
                            id="last-name"
                            type="text"
                            className="form-control"
                            placeholder="ex. Cruz"
                            maxLength={50}
                            required={true}
                        />
                        <InputError message={errors.last_name} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="first-name">
                            First Name *
                        </label>

                        <Input
                            value={data.first_name}
                            onChange={(e) => setData('first_name', e.target.value)}
                            id="first-name"
                            type="text"
                            className="form-control"
                            placeholder="ex. Juan"
                            maxLength={50}
                            required={true}
                        />
                        <InputError message={errors.first_name} className="mt-2" />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="middle-name">
                            Middle Name
                        </label>

                        <Input
                            value={data.middle_name}
                            onChange={(e) => setData('middle_name', e.target.value)}
                            id="middle-name"
                            type="text"
                            className="form-control"
                            placeholder="ex. Carlos"
                            maxLength={50}
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="suffix">
                            Suffix
                        </label>

                        <Select
                            value={data.patient_suffix_id}
                            onChange={(e) => setData('patient_suffix_id', parseInt(e.target.value))}
                            options={suffixOptions}
                            type="Suffix"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="gender">
                            Gender
                        </label>

                        <Select
                            value={data.gender_id}
                            onChange={(e) => setData('gender_id', parseInt(e.target.value))}
                            options={genderOptions}
                            type="Gender"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="middle-name">
                            Date Of Birth
                        </label>

                        <Input
                            value={data.date_of_birth}
                            onChange={(e) => computeAge(e)}
                            id="date-of-birth"
                            type="date"
                            className="form-control"
                            placeholder="Select Date"
                        />
                    </div>

                    <div className="form-group">
                        <label className="form-label" htmlFor="middle-name">
                            Age (y m d)
                        </label>

                        <Input
                            value={data.age}
                            onChange={(e) => inputAge(e)}
                            id="age"
                            type="text"
                            className="form-control"
                            placeholder="ex. 18y 0m 0d"
                        />
                    </div>

                    <div className="form-group">
                        <label className="form-label" htmlFor="occupation">
                            Occupation
                        </label>

                        <Input
                            id="occupation"
                            type="text"
                            className="form-control"
                            placeholder="ex. Construction Worker"
                            maxLength={50}
                            value={data.occupation}
                            onChange={(e) => setData('occupation', e.target.value)}
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="civil_status">
                            Civil Status
                        </label>

                        <Select
                            value={data.civil_status_id}
                            onChange={(e) => setData('civil_status_id', parseInt(e.target.value))}
                            options={civilStatusOptions}
                            type="Civil Status"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="nationality">
                            Nationality
                        </label>

                        <Select
                            value={data.nationality_id}
                            onChange={(e) => setData('nationality_id', parseInt(e.target.value))}
                            options={nationalityOptions}
                            type="Nationality"
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="contact-number-1">
                            Contact Number 1
                        </label>

                        <Input
                            value={data.contact_number1}
                            onChange={(e) => setData('contact_number1', e.target.value)}
                            id="contact-number-1"
                            type="text"
                            className="form-control"
                            placeholder="ex. 09xxxxxxxxx"
                            maxLength={50}
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="contact-number-2">
                            Contact Number 2
                        </label>

                        <Input
                            value={data.contact_number2}
                            onChange={(e) => setData('contact_number2', e.target.value)}
                            id="contact-number-2"
                            type="text"
                            className="form-control"
                            placeholder="ex. 09xxxxxxxxx"
                            maxLength={50}
                        />
                    </div>
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
                    <div className="form-group">
                        <label className="form-label" htmlFor="province">
                            PhilHealth ID
                        </label>

                        <Input
                            value={data.philhealth_id}
                            onChange={(e) => setData('philhealth_id', e.target.value)}
                            id="last-name"
                            type="text"
                            className="form-control"
                            maxLength={12}
                            placeholder="ex. xx-xxxxxxxxx-x"
                        />
                    </div>
                </div>
            </div>
        </section>
    );
};

export default NewPatientForm;
