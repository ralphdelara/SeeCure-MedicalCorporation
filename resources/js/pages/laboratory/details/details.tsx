import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import SignsOrSymptomsForm from '@/components/consultation/signs-or-symptoms-form';
import { Fragment, useEffect, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formSubmitResponse, getIdsFromArrayData } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/LaboratoryController';
import axios from 'axios';

interface InertiaProps {
    laboratoryDetails: {
        id: string;
        test_data: {
            tests: {
                id: string;
                fields: {
                    id: string;
                    field: {
                        id: string;
                        unit: string;
                        field_type: string;
                        name: string;
                    };
                }[];
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
                                <div className="row g-3 mt-3 w-100">
                                    {laboratoryDetails.test_data.map((item, index) => (
                                        <Fragment key={'testData-' + index}>
                                            <div className="col-md-12" key={'testType-' + index}>
                                                <h4 className="fw-bolder">{item.type}</h4>
                                            </div>
                                            {item.tests.map((testItem, testIndex) => {
                                                let fieldId =
                                                    'field_' +
                                                    testItem.id +
                                                    '_' +
                                                    testItem.fields[0].id +
                                                    '_' +
                                                    testItem.fields[0].field.id;

                                                let testId =
                                                    'test_' +
                                                    testItem.test.id +
                                                    '_remarks_' +
                                                    testItem.id +
                                                    '_' +
                                                    testItem.laboratory_package_id +
                                                    '_' +
                                                    testItem.laboratory_type_id;
                                                return (
                                                    <Fragment
                                                        key={'testData-' + index + '-' + testIndex}
                                                    >
                                                        {testItem.fields.length === 1 && (
                                                            <div
                                                                className="col-md-4"
                                                                key={
                                                                    'test-' +
                                                                    index +
                                                                    '-' +
                                                                    testIndex
                                                                }
                                                            >
                                                                <h5 className="fw-semibold">
                                                                    {testItem.test.name}
                                                                </h5>
                                                                <div className="input-group mb-3">
                                                                    <Input
                                                                        value={
                                                                            dataFields[
                                                                                fieldId as keyof typeof dataFields
                                                                            ] ?? ''
                                                                        }
                                                                        onChange={(e) =>
                                                                            changeFieldValue(
                                                                                e.target.value,
                                                                                fieldId,
                                                                            )
                                                                        }
                                                                        id={fieldId}
                                                                        type="text"
                                                                        maxLength={50}
                                                                        className="form-control"
                                                                    />
                                                                    <div className="input-group-append">
                                                                        <span className="input-group-text">
                                                                            {testItem.fields[0]
                                                                                .field.unit ?? '-'}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <Input
                                                                    value={
                                                                        dataFields[
                                                                            testId as keyof typeof dataFields
                                                                        ] ?? ''
                                                                    }
                                                                    onChange={(e) =>
                                                                        changeFieldValue(
                                                                            e.target.value,
                                                                            testId,
                                                                        )
                                                                    }
                                                                    id={testId}
                                                                    type="text"
                                                                    maxLength={50}
                                                                    placeholder="Remarks"
                                                                    className="form-control"
                                                                />
                                                            </div>
                                                        )}
                                                        {testItem.fields.length > 1 && (
                                                            <div
                                                                className="col-md-4"
                                                                key={
                                                                    'test-' +
                                                                    index +
                                                                    '-' +
                                                                    testIndex
                                                                }
                                                            >
                                                                <h5 className="fw-semibold">
                                                                    {testItem.test.name}
                                                                </h5>
                                                                {testItem.fields.map(
                                                                    (fieldItem, fieldIndex) => {
                                                                        let key =
                                                                            'field_' +
                                                                            index +
                                                                            '-' +
                                                                            testIndex +
                                                                            '-' +
                                                                            fieldIndex;

                                                                        let fieldId2 =
                                                                            'field_' +
                                                                            testItem.id +
                                                                            '_' +
                                                                            fieldItem.id +
                                                                            '_' +
                                                                            fieldItem.field.id;
                                                                        return (
                                                                            <Fragment key={key}>
                                                                                <h6
                                                                                    className={
                                                                                        fieldItem
                                                                                            .field
                                                                                            .field_type !==
                                                                                        'label'
                                                                                            ? 'fw-normal'
                                                                                            : 'fw-semibold'
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        fieldItem
                                                                                            .field
                                                                                            .name
                                                                                    }
                                                                                </h6>
                                                                                {fieldItem.field
                                                                                    .field_type !==
                                                                                    'label' && (
                                                                                    <div className="input-group mb-3">
                                                                                        <Input
                                                                                            value={
                                                                                                dataFields[
                                                                                                    fieldId2 as keyof typeof dataFields
                                                                                                ] ??
                                                                                                ''
                                                                                            }
                                                                                            onChange={(
                                                                                                e,
                                                                                            ) =>
                                                                                                changeFieldValue(
                                                                                                    e
                                                                                                        .target
                                                                                                        .value,
                                                                                                    fieldId2,
                                                                                                )
                                                                                            }
                                                                                            id={
                                                                                                fieldId2
                                                                                            }
                                                                                            type="text"
                                                                                            maxLength={
                                                                                                50
                                                                                            }
                                                                                            className="form-control"
                                                                                        />
                                                                                        <div className="input-group-append">
                                                                                            <span className="input-group-text">
                                                                                                {testItem
                                                                                                    .fields[0]
                                                                                                    .field
                                                                                                    .unit ??
                                                                                                    '-'}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                )}
                                                                            </Fragment>
                                                                        );
                                                                    },
                                                                )}

                                                                <Input
                                                                    value={
                                                                        dataFields[
                                                                            testId as keyof typeof dataFields
                                                                        ] ?? ''
                                                                    }
                                                                    onChange={(e) =>
                                                                        changeFieldValue(
                                                                            e.target.value,
                                                                            testId,
                                                                        )
                                                                    }
                                                                    id={testId}
                                                                    type="text"
                                                                    maxLength={50}
                                                                    placeholder="Remarks"
                                                                    className="form-control"
                                                                />
                                                            </div>
                                                        )}
                                                    </Fragment>
                                                );
                                            })}
                                        </Fragment>
                                    ))}
                                </div>
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
