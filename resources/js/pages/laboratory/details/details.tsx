import { Input } from '@/components/ui/input';
import { Fragment, useEffect, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { formSubmitResponse, printDocument } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/LaboratoryController';
import DetailsTestFields, { TestFieldProps } from './details-test-fields';
import { IconFlask } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { Select } from '@/components/ui/select';
import DetailsRemarks from './details-remarks';

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
    const { laboratoryDetails, staffOptions } = usePage().props as unknown as InertiaProps;
    const { data, patch, setData } = useForm({
        id: laboratoryDetails.id,
        performed_by: laboratoryDetails.performed_by?.id ?? '',
        date_performed: new Date(laboratoryDetails.date_performed ?? '').toLocaleDateString(
            'sv-SE',
        ),
    });

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, {
            ...formSubmitResponse('Details'),
        });
    };

    useEffect(() => {
        // Clean dataFields to turn any accidental 'undefined' into empty strings
        const cleanFields = Object.fromEntries(
            Object.entries(dataFields ?? {}).map(([key, val]) => [key, val ?? '']),
        );

        // Overwrite state, but explicitly preserve and protect your lab details
        setData({
            ...cleanFields,
            id: laboratoryDetails.id ?? '',
            performed_by: laboratoryDetails.performed_by?.id ?? '',
            date_performed: laboratoryDetails.date_performed
                ? new Date(laboratoryDetails.date_performed).toLocaleDateString('sv-SE')
                : '',
        });
    }, [dataFields]);

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={false} />
                        </div>
                        <div className="me-5 text-right">
                            <Button
                                size="lg"
                                type="button"
                                onClick={() => printDocument('laboratory', laboratoryDetails.id)}
                            >
                                <IconFlask />
                                Print Laboratory Results
                            </Button>
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                <div className="d-flex justify-content-end">
                                    <h5 className="me-1 mt-2">Performed By</h5>
                                    <div className="me-2">
                                        <Select
                                            options={staffOptions}
                                            type=""
                                            value={data.performed_by}
                                            onChange={(e) =>
                                                setData('performed_by', e.target.value)
                                            }
                                        />
                                    </div>
                                    <h5 className="me-1 mt-2">Date Performed</h5>
                                    <div className="">
                                        <Input
                                            type="date"
                                            value={data.date_performed}
                                            onChange={(e) =>
                                                setData('date_performed', e.target.value)
                                            }
                                        />
                                    </div>
                                </div>
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
                                                            {item.type_id === 2 &&
                                                                [
                                                                    'Urinalysis',
                                                                    'Fecalysis',
                                                                ].includes(test.test.name) && (
                                                                    <DetailsRemarks
                                                                        typeId={item.type_id}
                                                                        testId={test.test.id}
                                                                        fieldName={test.test.name}
                                                                        dataFields={dataFields}
                                                                        setDataFields={
                                                                            setDataFields
                                                                        }
                                                                    />
                                                                )}
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
                                        {item.type_id !== 2 && (
                                            <DetailsRemarks
                                                typeId={item.type_id}
                                                testId="0"
                                                fieldName={item.type}
                                                dataFields={dataFields}
                                                setDataFields={setDataFields}
                                            />
                                        )}
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
