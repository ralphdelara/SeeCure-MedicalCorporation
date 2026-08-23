import axios from 'axios';
import { useState } from 'react';
import { Select } from '../ui/select';
import { Input } from '@/components/ui/input';
import { AddressFormProps } from './types';
import { getBarangayList, getCityList } from '@/actions/App/Http/Controllers/AddressController';
import { usePage } from '@inertiajs/react';
import { Options } from '@/types/options';

interface InertiaProps {
    formOptions: {
        provinceOptions: Options[];
        cityOptions: Options[];
        barangayOptions: Options[];
    };
}

const AddressForm = ({ data, setData }: AddressFormProps) => {
    const { formOptions } = usePage().props as unknown as InertiaProps;
    const { provinceOptions, cityOptions, barangayOptions } = formOptions;
    const [barangayOptionsState, setBarangayOptionsState] = useState(barangayOptions);
    const [cityOptionsState, setCityOptionsState] = useState(cityOptions);

    const getBarangay = async (cityId: number) => {
        await axios.get(getBarangayList({ cityId: cityId }).url).then((res) => {
            setBarangayOptionsState(res.data);
        });
    };

    const getCity = async (provinceId: number) => {
        await axios.get(getCityList({ provinceId: provinceId }).url).then((res) => {
            setCityOptionsState(res.data);
        });
    };

    const toggleCity = (value: string) => {
        setData('city_id', value);
        const cityId = parseInt(value);
        if (isNaN(cityId)) {
            setData('barangay_id', '');
            setBarangayOptionsState([]);

            return;
        }
        getBarangay(cityId);
    };

    const toggleProvince = (value: string) => {
        setData('province_id', value);
        const provinceId = parseInt(value);
        if (isNaN(provinceId)) {
            setData('city_id', '');
            setData('barangay_id', '');
            setCityOptionsState([]);
            setBarangayOptionsState([]);

            return;
        }
        getCity(provinceId);
    };

    return (
        <>
            <div className="col-md-6">
                <div className="form-group">
                    <label className="form-label" htmlFor="province">
                        Province
                    </label>

                    <Select
                        value={data.province_id}
                        onChange={(e) => toggleProvince(e.target.value)}
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
                        onChange={(e) => toggleCity(e.target.value)}
                        options={cityOptionsState}
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
                        options={barangayOptionsState}
                        type="Barangay"
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
            </div><div className="col-md-6">
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
        </>
    );
};

export default AddressForm;
