import { IconFlask } from '@tabler/icons-react';
import { usePage } from '@inertiajs/react';
import { Fragment } from 'react';
import { getNormalRange } from '@/lib/utils';

const VisitDetailsLaboratory = ({ laboratory }) => {
    const { patientDetails } = usePage().props;

    return (
        <>
            <div className="d-flex justify-content-between mt-3">
                <h4 className="fw-bolder">
                    <IconFlask /> Laboratory
                </h4>
            </div>

            <table className="table" style={{ width: '100%' }}>
                <thead className="text-dark fs-4 table-success border-success">
                    <tr>
                        <th style={{ width: '30%' }}>Test</th>
                        <th style={{ width: '15%' }}>Value</th>
                        <th style={{ width: '15%' }}>Normal</th>
                        <th style={{ width: '20%' }}>Performed By</th>
                        <th style={{ width: '20%' }}>Date Performed</th>
                    </tr>
                </thead>
                <tbody>
                    {laboratory?.map((item, index) => (
                        <Fragment key={'lab-' + index}>
                            {item.test_data.map((testItem, testIndex) => (
                                <Fragment key={'lab-' + index + '-' + testIndex}>
                                    {testItem.fields.length > 1 && (
                                        <Fragment>
                                            <tr>
                                                <td colSpan={5}>
                                                    <h5 className="fw-bolder">
                                                        {testItem.test.name}
                                                    </h5>
                                                </td>
                                            </tr>
                                            {testItem.fields.map((field, fieldIndex) => (
                                                <tr key={'testList-' + index + '-' + fieldIndex}>
                                                    <td>
                                                        {field.field.name}{' '}
                                                        {field.field.unit != '' && (
                                                            <small>
                                                                <i>({field.field.unit})</i>
                                                            </small>
                                                        )}
                                                    </td>
                                                    <td>{field.value}</td>
                                                    <td>
                                                        {getNormalRange(
                                                            field.field,
                                                            patientDetails.gender.id,
                                                        )}
                                                    </td>
                                                    <td>
                                                        <h6 className="fw-normal">
                                                            {testItem.performed_by?.full_name ?? ''}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <h6 className="fw-normal">
                                                            {testItem.date_performed ?? ''}
                                                        </h6>
                                                    </td>
                                                </tr>
                                            ))}
                                        </Fragment>
                                    )}
                                    {testItem.fields.length === 1 && (
                                        <tr>
                                            <td className="text-nowrap">
                                                <h5 className="fw-bolder">{testItem.test.name}</h5>{' '}
                                                {testItem.fields[0].field.unit != '' && (
                                                    <small>
                                                        <i>({testItem.fields[0].field.unit})</i>
                                                    </small>
                                                )}
                                            </td>
                                            <td className="p-2">
                                                <h5>{testItem.fields[0].value}</h5>
                                            </td>
                                            <td>
                                                {getNormalRange(
                                                    testItem.fields[0].field,
                                                    patientDetails.gender.id,
                                                )}
                                            </td>
                                            <td>
                                                <h6 className="fw-normal">
                                                    {testItem.performed_by?.full_name ?? ''}
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 className="fw-normal">
                                                    {testItem.date_performed ?? ''}
                                                </h6>
                                            </td>
                                        </tr>
                                    )}
                                </Fragment>
                            ))}
                        </Fragment>
                    ))}
                </tbody>
            </table>
        </>
    );
};

export default VisitDetailsLaboratory;
