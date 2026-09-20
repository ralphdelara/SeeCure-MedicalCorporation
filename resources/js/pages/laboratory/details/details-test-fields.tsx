import { Input } from '@/components/ui/input';
import { getNormalRange } from '@/lib/utils';
import { usePage } from '@inertiajs/react';
import { Fragment, useEffect, useState } from 'react';

export interface NormalRangeProps {
    normal_range_both_min: string;
    normal_range_female_min: string;
    normal_range_male_min: string;
    normal_range_both_max: string;
    normal_range_female_max: string;
    normal_range_male_max: string;
}

export interface TestFieldProps {
    id: string;
    field: {
        id: string;
        name: string;
        field_type: string;
        unit: string;
    } & NormalRangeProps;
}

const DetailsTestFields = ({
    test,
    index,
    testIndex,
    dataFields,
    setDataFields,
    isOneField = false,
}: {
    test: {
        id: string;
        fields: TestFieldProps[];
    };
    index: number;
    testIndex: number;
    dataFields: object;
    setDataFields: React.Dispatch<React.SetStateAction<{}>>;
    isOneField?: boolean;
}) => {
    const { patientDetails } = usePage().props as unknown as {
        patientDetails: {
            gender_id: number;
        };
    };

    const changeFieldValue = (value: string, fieldId: string) => {
        let fields: Record<string, any> = {
            ...dataFields,
        };
        fields[fieldId] = value;

        setDataFields(fields);
    };

    return (
        <>
            {test.fields.map((testField, testFieldIndex) => {
                let fieldId = 'field_' + test.id + '_' + testField.id + '_' + testField.field.id;
                let normalRange = getNormalRange(testField.field, patientDetails.gender_id ?? 0);
                return (
                    <Fragment key={'key-' + fieldId}>
                        {testField.field.field_type === 'label' && (
                            <div className="col-md-12">
                                <h6 className="fw-semibold">{testField.field.name}</h6>
                            </div>
                        )}
                        {testField.field.field_type !== 'label' && (
                            <div
                                className={isOneField ? 'col-md-12' : 'col-md-3'}
                                key={'testField-' + index + '-' + testIndex + '-' + testFieldIndex}
                            >
                                {testField.field.name !== 'Result' && (
                                    <div className="d-flex justify-content-between">
                                        <h6 className="fw-semibold">{testField.field.name}</h6>
                                        <h6>{normalRange}</h6>
                                    </div>
                                )}

                                <div className="input-group mb-3">
                                    <Input
                                        value={dataFields[fieldId as keyof typeof dataFields] ?? ''}
                                        onChange={(e) => changeFieldValue(e.target.value, fieldId)}
                                        id={fieldId}
                                        type="text"
                                        maxLength={50}
                                        className="form-control"
                                    />
                                    <div className="input-group-append">
                                        <span
                                            className="input-group-text"
                                            style={{ borderRadius: '0 7px 7px 0' }}
                                        >
                                            {testField.field.unit ?? '-'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        )}
                    </Fragment>
                );
            })}
        </>
    );
};

export default DetailsTestFields;
