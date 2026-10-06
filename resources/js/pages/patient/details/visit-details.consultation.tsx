import { IconEye, IconStethoscope } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import DOMPurify from 'dompurify';
import { Fragment } from 'react';

const VisitDetailsConsultation = ({ consultation }) => {
    return (
        <div className="fs-4">
            <div className="d-flex justify-content-between">
                <h4 className="fw-bolder">
                    <IconStethoscope /> Consultation
                </h4>
                <Button
                    variant="default"
                    title="Open Consultation Details"
                    rounded={true}
                    onClick={() => router.get(getConsultationDetails(consultation.id).url)}
                >
                    <i>
                        <IconEye />
                    </i>
                </Button>
            </div>

            <div className="bg-success-subtle ps-2 pt-1 pb-1">
                <h5>Details</h5>
            </div>
            <div className="fw-semibold p-2">
                <table style={{ width: '100%' }}>
                    <tbody>
                        <tr>
                            <td style={{ width: '30%' }}>DateTime:</td>
                            <td className="text-dark">{consultation.created_at}</td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Attending Doctor:</td>
                            <td className="text-dark">{consultation.doctor.full_name ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Signs / Symptoms:</td>
                            <td className="text-dark">
                                {consultation.signs_or_symptoms.map((symptoms, index) => (
                                    <Fragment key={'symptoms-' + index}>
                                        {index > 0 && <>, </>}
                                        <span>{symptoms.name}</span>
                                    </Fragment>
                                ))}
                            </td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Reason for Consult:</td>
                            <td className="text-dark">{consultation.consult_reason ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Guardian:</td>
                            <td className="text-dark">{consultation.guardian_name ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Guardian Contact:</td>
                            <td className="text-dark">
                                {consultation.guardian_contact_number ?? 'N/A'}
                            </td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Guardian Email:</td>
                            <td className="text-dark">{consultation.guardian_email ?? 'N/A'}</td>
                        </tr>
                        <tr>
                            <td style={{ width: '30%' }}>Guardian Relationship:</td>
                            <td className="text-dark">
                                {consultation.guardian_relationship?.name ?? 'N/A'}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {consultation?.vital_signs && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Vital Signs</h5>
                    </div>
                    <div>
                        <table style={{ width: '100%' }}>
                            <thead>
                                <tr className="text-dark">
                                    <th>
                                        <div className="text-right">#</div>
                                    </th>
                                    <th>Vital Sign • unit</th>
                                    <th>Value</th>
                                    <th>Added by</th>
                                </tr>
                            </thead>
                            <tbody>
                                {consultation?.vital_signs.map((item, index) => {
                                    return (
                                        <tr key={'vitalSigns-' + item.id}>
                                            <td
                                                className="p-1 text-right"
                                                style={{ verticalAlign: 'top' }}
                                            >
                                                {index + 1}
                                            </td>
                                            <td className="p-1">
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.vital_sign_field.name} •{' '}
                                                            {item.vital_sign_field.unit}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.vital_sign.name}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                style={{ verticalAlign: 'top' }}
                                                className="text-dark"
                                            >
                                                {item.value}
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.created_by?.full_name ?? ''}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.created_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    );
                                })}
                            </tbody>
                        </table>
                    </div>
                </>
            )}
            {consultation?.soap?.subjective && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Subjective</h5>
                    </div>
                    <div
                        className="fw-semibold html-list-reset text-dark"
                        dangerouslySetInnerHTML={{
                            __html: DOMPurify.sanitize(consultation.soap.subjective),
                        }}
                    ></div>
                </>
            )}
            {consultation?.soap?.assessment && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Assessment</h5>
                    </div>
                    <div
                        className="fw-semibold html-list-reset text-dark"
                        dangerouslySetInnerHTML={{
                            __html: DOMPurify.sanitize(consultation.soap.assessment),
                        }}
                    ></div>
                </>
            )}
            {consultation?.soap?.plan && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Plan</h5>
                    </div>
                    <div
                        className="fw-semibold html-list-reset text-dark"
                        dangerouslySetInnerHTML={{
                            __html: DOMPurify.sanitize(consultation.soap.plan),
                        }}
                    ></div>
                </>
            )}
            {consultation?.diagnosis?.diagnosis && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Diagnosis</h5>
                    </div>
                    <div
                        className="fw-semibold html-list-reset text-dark"
                        dangerouslySetInnerHTML={{
                            __html: DOMPurify.sanitize(consultation.diagnosis.diagnosis),
                        }}
                    ></div>
                </>
            )}
            {consultation?.diagnosis?.icd10_codes.length > 0 && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>ICD10 Codes</h5>
                    </div>
                    <div className="fw-semibold html-list-reset text-dark">
                        <ul>
                            {consultation?.diagnosis?.icd10_codes.map((icd10Code, index) => (
                                <li key={'icd10' + index}>
                                    {icd10Code.icd10_code.code} - {icd10Code.icd10_code.description}
                                </li>
                            ))}
                        </ul>
                    </div>
                </>
            )}
            {consultation?.prescriptions?.length > 0 && (
                <>
                    <div className="bg-success-subtle ps-2 pt-1 pb-1">
                        <h5>Prescriptions</h5>
                    </div>
                    <div className="fw-semibold html-list-reset text-dark">
                        <ul>
                            {consultation?.prescriptions?.map((prescription, index) => (
                                <li key={'pres-' + index}>
                                    <div>
                                        {prescription.inventory_name} x {prescription.quantity}
                                    </div>
                                    <i>{prescription.sig}</i>
                                </li>
                            ))}
                        </ul>
                    </div>
                </>
            )}
        </div>
    );
};

export default VisitDetailsConsultation;
