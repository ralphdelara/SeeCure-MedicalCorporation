import { Input } from '@/components/ui/input';
import { Fragment, useEffect, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { formSubmitResponse } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/LaboratoryController';
import DetailsTestFields, { TestFieldProps } from './details-test-fields';

interface InertiaProps {
    laboratoryDetails: {
        id: string;
        test_data: {
            tests: {
                id: string;
                fields: TestFieldProps[];
                laboratory_package_id: string;
                laboratory_type_id: string;
                test: {
                    id: string;
                    name: string;
                };
            }[];
            type: string;
        }[];
    };
}

const Details = ({
    showTab,
    dataFields,
    setDataFields,
}: {
    showTab: boolean;
    dataFields: object;
    setDataFields: React.Dispatch<React.SetStateAction<{}>>;
}) => {
    const { laboratoryDetails } = usePage().props as unknown as InertiaProps;
    const { patch, setData } = useForm();

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, {
            ...formSubmitResponse('Details'),
        });
    };

    const changeFieldValue = (value: string, fieldId: string) => {
        let fields: Record<string, any> = {
            ...dataFields,
        };
        fields[fieldId] = value;

        setDataFields(fields);
    };

    useEffect(() => {
        setData({ ...dataFields, id: laboratoryDetails.id });
    }, [dataFields]);
    console.log(laboratoryDetails.test_data);
    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={false} />
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                {laboratoryDetails.test_data.map((item, index) => (
                                    <Fragment key={'type-' + index}>
                                        <h4 className="fw-bolder">{item.type}</h4>
                                        <div className="row mt-3 w-100">
                                            {item.tests.map((test, testIndex) => (
                                                <Fragment key={'test-' + index + '-' + testIndex}>
                                                    {test.fields.length > 1 && (
                                                        <>
                                                            <div className="col-md-12">
                                                                <h5 className="fw-semibold">
                                                                    {test.test.name}
                                                                </h5>
                                                            </div>
                                                            <DetailsTestFields
                                                                test={test}
                                                                index={index}
                                                                testIndex={testIndex}
                                                                dataFields={dataFields}
                                                                setDataFields={setDataFields}
                                                            />
                                                            <div className="col-md-12"></div>
                                                        </>
                                                    )}
                                                    {test.fields.length === 1 && (
                                                        <div className="col-md-3">
                                                            {test.fields[0].field.name ===
                                                                'Result' && (
                                                                <div className="d-flex justify-content-between">
                                                                    <h6 className="fw-semibold">
                                                                        {test.test.name}
                                                                    </h6>
                                                                </div>
                                                            )}
                                                            <DetailsTestFields
                                                                test={test}
                                                                index={index}
                                                                testIndex={testIndex}
                                                                dataFields={dataFields}
                                                                setDataFields={setDataFields}
                                                                isOneField={true}
                                                            />
                                                        </div>
                                                    )}
                                                </Fragment>
                                            ))}
                                        </div>
                                    </Fragment>
                                ))}
                            </div>
                        </div>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={false} />
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

export default Details;
