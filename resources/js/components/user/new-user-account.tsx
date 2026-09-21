import { usePage } from '@inertiajs/react';
import InputError from '@/components/input-error';
import PasswordInput from '../password-input';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { AddOrUpdateUserFormProps } from './new-user';
import { Fragment } from 'react';
interface User {
    id: string;
    full_name: string;
    is_admin: boolean;
}

interface InertiaProps {
    auth: { user: User; professions: string[]; specialties: string[] };
    formOptions: {
        departmentOptions: Options[];
        professionOptions: Options[];
        specialtyOptions: Options[];
        positionOptions: Options[];
    };
}

const Account = ({ data, setData, errors = {} }: AddOrUpdateUserFormProps) => {
    const { formOptions, auth } = usePage().props as unknown as InertiaProps;
    const { departmentOptions, professionOptions, specialtyOptions, positionOptions } = formOptions;

    const updateDepartment = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('department_ids', [...data.department_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'department_ids',
                data.department_ids.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };
    const updatePosition = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('position_ids', [...data.position_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'position_ids',
                data.position_ids.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };
    const updateProfession = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('profession_ids', [...data.profession_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'profession_ids',
                data.profession_ids.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };
    const updateSpecialty = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('specialty_ids', [...data.specialty_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'specialty_ids',
                data.specialty_ids.filter((item) => item !== parseInt(e.target.value)),
            );
        }
    };

    return (
        <div className="border-bottom">
            <h5 className="fw-semibold">Account Details</h5>
            <div className="row">
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="username">
                            Username *
                        </label>

                        <Input
                            value={data.username}
                            onChange={(e) => setData('username', e.target.value)}
                            id="username"
                            type="text"
                            className="form-control"
                            placeholder="ex. juancruz"
                            maxLength={50}
                            required={true}
                        />
                        <InputError message={errors.username} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="password">
                            Password
                            {data.user_id === '' && ' *'}
                            {data.user_id !== '' && ' (fill this to change user password)'}
                        </label>

                        <PasswordInput
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            id="password"
                            className="form-control"
                            placeholder="ex. secretpass"
                            maxLength={50}
                            required={data.user_id === ''}
                        />
                        <InputError message={errors.password} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="department_ids">
                            Department
                        </label>

                        <div className="row">
                            {departmentOptions?.map((item, index) => (
                                <Fragment key={'department-' + index}>
                                    {
                                        /*hides Administrator checkbox in non admin users*/
                                        (auth.user.is_admin ||
                                            (item.id !== 1 && !auth.user.is_admin)) && (
                                            <div className="col-md-4">
                                                <div className="form-check form-check-inline">
                                                    <input
                                                        className="form-check-input success"
                                                        type="checkbox"
                                                        id={'department-' + index}
                                                        value={item.id}
                                                        onChange={(e) => updateDepartment(e)}
                                                        name="department"
                                                        checked={data.department_ids?.includes(
                                                            item.id,
                                                        )}
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={'department-' + index}
                                                    >
                                                        {item.name}
                                                    </label>
                                                </div>
                                            </div>
                                        )
                                    }
                                </Fragment>
                            ))}
                            <InputError message={errors.department_ids} className="mt-2" />
                        </div>
                    </div>
                </div>
                <div className="col-md-12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="position_ids">
                            Position
                        </label>

                        <div className="row">
                            {positionOptions?.map((item, index) => (
                                <Fragment key={'position-' + index}>
                                    {
                                        /*hides Bot checkbox*/
                                        item.id !== 14 && (
                                            <div className="col-md-4">
                                                <div className="form-check form-check-inline">
                                                    <input
                                                        className="form-check-input success"
                                                        type="checkbox"
                                                        id={'position-' + index}
                                                        value={item.id}
                                                        onChange={(e) => updatePosition(e)}
                                                        name="position"
                                                        checked={data.position_ids?.includes(
                                                            item.id,
                                                        )}
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={'position-' + index}
                                                    >
                                                        {item.name}
                                                    </label>
                                                </div>
                                            </div>
                                        )
                                    }
                                </Fragment>
                            ))}
                            <InputError message={errors.position_ids} className="mt-2" />
                        </div>
                    </div>
                </div>
                <div className="col-md-12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="profession_ids">
                            Profession
                        </label>

                        <div className="row">
                            {professionOptions?.map((item, index) => (
                                <div className="col-md-4" key={'profession-' + index}>
                                    <div className="form-check form-check-inline">
                                        <input
                                            className="form-check-input success"
                                            type="checkbox"
                                            id={'profession-' + index}
                                            value={item.id}
                                            onChange={(e) => updateProfession(e)}
                                            name="profession"
                                            checked={data.profession_ids?.includes(item.id)}
                                        />
                                        <label
                                            className="form-check-label"
                                            htmlFor={'profession-' + index}
                                        >
                                            {item.name}
                                        </label>
                                    </div>
                                </div>
                            ))}
                            <InputError message={errors.profession_ids} className="mt-2" />
                        </div>
                    </div>
                </div>
                <div className="col-md-12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="profession_ids">
                            Specialty
                        </label>

                        <div className="row">
                            {specialtyOptions?.map((item, index) => (
                                <div className="col-md-4" key={'specialty-' + index}>
                                    <div className="form-check form-check-inline">
                                        <input
                                            className="form-check-input success"
                                            type="checkbox"
                                            id={'specialty-' + index}
                                            value={item.id}
                                            onChange={(e) => updateSpecialty(e)}
                                            name="specialty"
                                            checked={data.specialty_ids?.includes(item.id)}
                                        />
                                        <label
                                            className="form-check-label"
                                            htmlFor={'specialty-' + index}
                                        >
                                            {item.name}
                                        </label>
                                    </div>
                                </div>
                            ))}
                            <InputError message={errors.specialty_ids} className="mt-2" />
                        </div>
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="license_no">
                            PRC License No
                        </label>

                        <Input
                            value={data.license_no}
                            onChange={(e) => setData('license_no', e.target.value)}
                            id="license_no"
                            type="text"
                            className="form-control"
                            placeholder="ex. 123401234"
                            maxLength={50}
                        />
                        <InputError message={errors.license_no} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="ptr_no">
                            PTR No
                        </label>

                        <Input
                            value={data.ptr_no}
                            onChange={(e) => setData('ptr_no', e.target.value)}
                            id="ptr_no"
                            type="text"
                            className="form-control"
                            placeholder="ex. 123401234"
                            maxLength={50}
                        />
                        <InputError message={errors.ptr_no} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="date_hired">
                            Date Hired
                        </label>

                        <Input
                            value={data.date_hired}
                            onChange={(e) => setData('date_hired', e.target.value)}
                            id="date_hired"
                            type="date"
                            className="form-control"
                            placeholder="ex. dd/mm/yyyy"
                            maxLength={50}
                        />
                        <InputError message={errors.date_hired} className="mt-2" />
                    </div>
                </div>
                <div className="col-md-6 mb-3">
                    <div className="form-group">
                        <label className="form-label" htmlFor="date_resigned">
                            Date Resigned
                        </label>

                        <Input
                            value={data.date_resigned}
                            onChange={(e) => setData('date_resigned', e.target.value)}
                            id="date_resigned"
                            type="date"
                            className="form-control"
                            placeholder="ex. dd/mm/yyyy"
                            maxLength={50}
                        />
                        <InputError message={errors.date_resigned} className="mt-2" />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Account;
