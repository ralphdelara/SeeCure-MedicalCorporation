import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { AddOrUpdatePatientFormProps } from './new-patient';
import { getExactAge } from '@/lib/utils';
import { useEffect, useState } from 'react';
import FormHeader from '../ui/form-header';
import { IconUserExclamation } from '@tabler/icons-react';

interface InertiaProps {
    formOptions: {
        genderOptions: Options[];
        civilStatusOptions: Options[];
        nationalityOptions: Options[];
        suffixOptions: Options[];
    };
}

const Personal = ({ data, setData, errors = {} }: AddOrUpdatePatientFormProps) => {
    const { formOptions } = usePage().props as unknown as InertiaProps;
    const { genderOptions, civilStatusOptions, nationalityOptions, suffixOptions } = formOptions;
    const [showHideSenior, setShowHideSenior] = useState(false);

    const inputAge = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (data.date_of_birth === '') {
            setData('age', parseInt(e.target.value));
        }
    };

    const changeDateOfBirth = (e: React.ChangeEvent<HTMLInputElement>) => {
        setData('date_of_birth', e.target.value);
        computeAge(e.target.value);
    };

    const computeAge = (dateOfBirth: string) => {
        const currentDate = new Date().toISOString().split('T')[0];
        const { years, months, days } = getExactAge(dateOfBirth, currentDate);

        if (isNaN(years) && isNaN(months) && isNaN(days)) {
            setData('age', '');
            setShowHideSenior(false);

            return;
        }

        if (years >= 60) {
            setShowHideSenior(true);
        } else {
            setShowHideSenior(false);
        }

        if (years < 0) {
            setData('age', 0);
        } else {
            setData('age', years + 'y ' + months + 'm ' + days + 'd');
        }
    };

    useEffect(() => {
        if (data.date_of_birth !== '') {
            computeAge(data.date_of_birth ?? '');
        }
    }, []);

    return (
        <div className="border-bottom">
            <FormHeader>Personal Details</FormHeader>
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
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label text-danger" htmlFor="control_no">
                            Control No <IconUserExclamation size="15" />
                        </label>

                        <Input
                            value={data.control_no}
                            onChange={(e) => setData('control_no', e.target.value)}
                            id="control_no"
                            type="text"
                            className="form-control"
                            placeholder="123"
                            maxLength={10}
                        />
                        <InputError message={errors.control_no} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="middle-name">
                            Date Of Birth
                        </label>

                        <Input
                            value={data.date_of_birth}
                            onChange={(e) => changeDateOfBirth(e)}
                            id="date-of-birth"
                            type="date"
                            className="form-control"
                            placeholder="Select Date"
                        />
                    </div>
                </div>
                {showHideSenior && (
                    <div className="col-md-6">
                        <div className="form-group">
                            <label className="form-label" htmlFor="middle-name">
                                Senior Citizen ID
                            </label>

                            <Input
                                value={data.senior_citizen_id}
                                onChange={(e) => setData('senior_citizen_id', e.target.value)}
                                id="senior_citizen_id"
                                type="text"
                                className="form-control"
                                placeholder="ex. 1234567"
                                maxLength={50}
                            />
                        </div>
                    </div>
                )}
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
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
                </div>
                <div className="col-md-6">
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
                        <label className="form-label" htmlFor="philhealth_id">
                            PhilHealth ID
                        </label>

                        <Input
                            value={data.philhealth_id}
                            onChange={(e) => setData('philhealth_id', e.target.value)}
                            id="philhealth_id"
                            type="text"
                            className="form-control"
                            maxLength={12}
                            placeholder="ex. xx-xxxxxxxxx-x"
                        />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="pwd_id">
                            PWD ID (this will auto set patient as pwd)
                        </label>

                        <Input
                            value={data.pwd_id}
                            onChange={(e) => setData('pwd_id', e.target.value)}
                            id="pwd_id"
                            type="text"
                            className="form-control"
                            maxLength={20}
                            placeholder="ex. xxxxxxxxxx"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Personal;
