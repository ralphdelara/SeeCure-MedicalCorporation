import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { AddOrUpdateUserFormProps } from './new-user';

interface InertiaProps {
    userFormOptions: {
        genderOptions: Options[];
    };
}

const Personal = ({ data, setData, errors = {} }: AddOrUpdateUserFormProps) => {
    const { userFormOptions } = usePage().props as unknown as InertiaProps;
    const { genderOptions } = userFormOptions;

    return (
        <div className="border-bottom">
            <h5 className="fw-semibold mt-3">Personal Details</h5>
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
                <div className="col-md-6 mb-3">
                    <div className="form-group">
                        <label className="form-label" htmlFor="middle-name">
                            Date Of Birth
                        </label>

                        <Input
                            value={data.date_of_birth}
                            onChange={(e) => setData('date_of_birth', e.target.value)}
                            id="date-of-birth"
                            type="date"
                            className="form-control"
                            placeholder="Select Date"
                        />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Personal;