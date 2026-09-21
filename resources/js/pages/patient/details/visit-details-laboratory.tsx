import { IconEye, IconFlask, IconStethoscope } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { router, usePage } from '@inertiajs/react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import DOMPurify from 'dompurify';
import { getLaboratoryDetails } from '@/actions/App/Http/Controllers/LaboratoryController';
import { Fragment } from 'react';
import { getNormalRange } from '@/lib/utils';

const VisitDetailsLaboratory = ({ laboratory }) => {
    const { patientDetails } = usePage().props;

    return (
        <>
            <div className="d-flex justify-content-between">
                <h4 className="fw-bolder">
                    <IconFlask /> Laboratory
                </h4>
            </div>

            <table style={{ width: '100%' }}>
                <thead>
                    <tr>
                        <th style={{ width: '30%' }}>Test</th>
                        <th className="p-2" style={{ width: '20%' }}>
                            Value
                        </th>
                        <th style={{ width: '25%' }}>Performed By</th>
                        <th style={{ width: '25%' }}>Date Performed</th>
                    </tr>
                </thead>
                <tbody>
                    {laboratory?.map((item, index) => (
                        <Fragment key={'lab-' + index}>
                            {item.test_data.map((testItem, testIndex) => (
                                <Fragment key={'lab-' + index + '-' + testIndex}>
                                    {testItem.fields.length > 1 && (
                                        <Fragment>
                                            {testItem.fields.map((field, fieldIndex) => (
                                                <tr key={'testList-' + index + '-' + fieldIndex}>
                                                    <td>{field.field.name}</td>
                                                    <td>{field.value}</td>
                                                    <td>
                                                        <h6 className="fw-normal">
                                                            {item.performed_by.full_name ?? ''}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <h6 className="fw-normal">
                                                            {item.date_performed ?? ''}
                                                        </h6>
                                                    </td>
                                                </tr>
                                            ))}
                                        </Fragment>
                                    )}
                                    {testItem.fields.length === 1 && (
                                        <tr>
                                            <td className="text-nowrap">
                                                <h5 className="fw-bolder">{testItem.test.name}</h5>
                                                {getNormalRange(
                                                    testItem.fields[0].field,
                                                    patientDetails.gender_id ?? 0,
                                                )}
                                            </td>
                                            <td className="p-2">
                                                <h5>{testItem.fields[0].value}</h5>
                                            </td>
                                            <td>
                                                <h6 className="fw-normal">
                                                    {item.performed_by.full_name ?? ''}
                                                </h6>
                                            </td>
                                            <td>
                                                <h6 className="fw-normal">
                                                    {item.date_performed ?? ''}
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
