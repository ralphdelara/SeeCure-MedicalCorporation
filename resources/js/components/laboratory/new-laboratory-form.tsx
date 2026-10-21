import { AddOrUpdateLaboratoryFormProps } from './new-laboratory';
import { Select } from '../ui/select';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { getTests } from '@/actions/App/Http/Controllers/LaboratoryController';
import { Label } from '../ui/label';
import { IconCheck, IconSquareCheck, IconSquareCheckFilled } from '@tabler/icons-react';
import { Options } from '@/types/options';
import InputError from '../input-error';

interface InertiaProps {
    laboratoryFormOptions: {
        laboratoryPackageOptions: Options[];
    };
}

const NewLaboratoryForm = ({ data, setData, errors = {} }: AddOrUpdateLaboratoryFormProps) => {
    const { laboratoryFormOptions } = usePage().props as unknown as InertiaProps;
    const { laboratoryPackageOptions } = laboratoryFormOptions;
    const [selectedPackage, setSelectedPackage] = useState<
        Partial<{
            name: string;
            price: string;
            tests: { name: string }[];
        }>
    >({});
    const [otherTests, setOtherTests] = useState<
        {
            tests: {
                id: string;
                name: string;
            }[];
            type: string;
        }[]
    >([]);

    const getTestOptions = async (laboratoryPackageId: number) => {
        await axios.get(getTests(laboratoryPackageId).url).then((res) => {
            setOtherTests(res.data.otherTests);
            setSelectedPackage(res.data.selectedPackage);
        });
    };

    const togglePackage = (value: string) => {
        setData('laboratory_package_id', value);
        if (value === '') {
            setSelectedPackage({});
            setOtherTests([]);

            return;
        }

        const laboratoryPackageId = parseInt(value);

        if (isNaN(laboratoryPackageId)) {
            return;
        }

        getTestOptions(laboratoryPackageId);
    };

    const updateOtherTest = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('other_test_ids', [...data.other_test_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'other_test_ids',
                data.other_test_ids.filter((item) => parseInt(item) !== parseInt(e.target.value)),
            );
        }
    };

    useEffect(() => {
        if (data.laboratory_package_id !== '') {
            togglePackage(data.laboratory_package_id);
        }
    }, []);

    return (
        <>
            <div className="mb-3">
                <Select
                    value={data.laboratory_package_id}
                    onChange={(e) => togglePackage(e.target.value)}
                    options={laboratoryPackageOptions}
                    type="Package"
                />
                <InputError message={errors.laboratory_package_id} className="mt-2" />
            </div>
            {Object.keys(selectedPackage).length > 0 && data.laboratory_package_id !== '' && (
                <div className="mt-2">
                    <Label className="form-label fs-5">Selected Package</Label>
                    <div>
                        <Label className="form-label fs-4">
                            {selectedPackage.name}{' '}
                            {selectedPackage.price !== '0.00' && <>({selectedPackage.price})</>}
                        </Label>
                        <div className="row">
                            {selectedPackage.tests?.map((itemTest, indexTest) => (
                                <div
                                    className={'col-md-6'}
                                    key={'selectedPackageTest-' + indexTest}
                                >
                                    <Label>
                                        <IconSquareCheckFilled className="text-success" /> {itemTest.name}
                                    </Label>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            )}
            {otherTests.length > 0 && (
                <Label className="form-label fs-5 mt-2">Select Other Tests (optional)</Label>
            )}
            {otherTests?.map((item, index) => (
                <div key={'lab-type-' + index}>
                    <Label className="form-label fs-4">{item.type}</Label>
                    <div className="row">
                        {item.tests.map((itemTest, indexTest) => (
                            <div className={'col-md-6'} key={'otherTests-' + indexTest}>
                                <div className="form-check form-check-inline">
                                    <input
                                        className="form-check-input success"
                                        type="checkbox"
                                        id={'other-test-' + itemTest.id}
                                        value={itemTest.id}
                                        onChange={(e) => updateOtherTest(e)}
                                        name="other-test"
                                        checked={data.other_test_ids.includes(itemTest.id)}
                                    />
                                    <label
                                        className="form-check-label"
                                        htmlFor={'other-test-' + itemTest.id}
                                    >
                                        {itemTest.name}
                                    </label>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            ))}
            <InputError message={errors.other_test_ids} className="mt-2" />
        </>
    );
};

export default NewLaboratoryForm;
