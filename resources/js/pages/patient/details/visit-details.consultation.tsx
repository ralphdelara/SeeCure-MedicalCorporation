import { IconEye, IconStethoscope } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import DOMPurify from 'dompurify';
import { Fragment } from 'react';
import FormHeader from '@/components/ui/form-header';

const VisitDetailsConsultation = ({ consultation }) => {
    return (
        <div className="fs-4">
            <div className="d-flex justify-content-between mt-3">
                <h4 className="fw-bolder">
                    <IconStethoscope /> Consultation
                </h4>
                <Button
                    variant="default"
                    title="Open Consultation Details"
                    onClick={() => router.get(getConsultationDetails(consultation.id).url)}
                >
                    <IconStethoscope /> View Consultation
                </Button>
            </div>

            <FormHeader>Details</FormHeader>

            <table className="table" style={{ width: '100%' }}>
                <thead className="text-dark fs-4 table-success border-success">
                    <tr>
                        <th></th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="30%">DateTime:</td>
                        <td className="fs-4 fw-semibold">{consultation.created_at}</td>
                    </tr>
                    <tr>
                        <td>Attending Doctor:</td>
                        <td className="fs-4 fw-semibold">
                            {consultation.doctor.full_name ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td>Signs / Symptoms:</td>
                        <td className="fs-4 fw-semibold">
                            {consultation.signs_or_symptoms.map((symptoms, index) => (
                                <Fragment key={'symptoms-' + index}>
                                    {index > 0 && <>, </>}
                                    <span>{symptoms.name}</span>
                                </Fragment>
                            ))}
                        </td>
                    </tr>
                    <tr>
                        <td>Reason for Consult:</td>
                        <td className="fs-4 fw-semibold">{consultation.consult_reason ?? 'N/A'}</td>
                    </tr>
                    <tr>
                        <td>Guardian:</td>
                        <td className="fs-4 fw-semibold">{consultation.guardian_name ?? 'N/A'}</td>
                    </tr>
                    <tr>
                        <td>Guardian Contact:</td>
                        <td className="fs-4 fw-semibold">
                            {consultation.guardian_contact_number ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td>Guardian Email:</td>
                        <td className="fs-4 fw-semibold">{consultation.guardian_email ?? 'N/A'}</td>
                    </tr>
                    <tr>
                        <td>Guardian Relationship:</td>
                        <td className="fs-4 fw-semibold">
                            {consultation.guardian_relationship?.name ?? 'N/A'}
                        </td>
                    </tr>
                </tbody>
            </table>

            <FormHeader>S O A P</FormHeader>

            <table className="table" style={{ width: '100%' }}>
                <thead className="text-dark fs-4 table-success border-success">
                    <tr>
                        <th></th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    {consultation?.soap?.subjective && (
                        <tr>
                            <td width="20%">
                                Subjective /
                                <br />
                                <small>Objective</small>
                            </td>
                            <td>
                                <div
                                    className="fw-semibold html-list-reset text-dark"
                                    dangerouslySetInnerHTML={{
                                        __html: DOMPurify.sanitize(consultation.soap.subjective),
                                    }}
                                ></div>
                            </td>
                        </tr>
                    )}
                    {consultation?.soap?.assessment && (
                        <>
                            <tr>
                                <td>Assessment</td>
                                <td>
                                    <div
                                        className="fw-semibold html-list-reset text-dark"
                                        dangerouslySetInnerHTML={{
                                            __html: DOMPurify.sanitize(
                                                consultation.soap.assessment,
                                            ),
                                        }}
                                    ></div>
                                </td>
                            </tr>
                        </>
                    )}
                    {consultation?.soap?.plan && (
                        <>
                            <tr>
                                <td>Plan</td>
                                <td>
                                    <div
                                        className="fw-semibold html-list-reset text-dark"
                                        dangerouslySetInnerHTML={{
                                            __html: DOMPurify.sanitize(consultation.soap.plan),
                                        }}
                                    ></div>
                                </td>
                            </tr>
                        </>
                    )}
                </tbody>
            </table>

            <FormHeader>Diagnosis</FormHeader>

            <table className="table" style={{ width: '100%' }}>
                <thead className="text-dark fs-4 table-success border-success">
                    <tr>
                        <th></th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    {consultation?.diagnosis?.diagnosis && (
                        <>
                            <tr>
                                <td width="20%">Diagnosis</td>
                                <td>
                                    <div
                                        className="fw-semibold html-list-reset text-dark"
                                        dangerouslySetInnerHTML={{
                                            __html: DOMPurify.sanitize(
                                                consultation.diagnosis.diagnosis,
                                            ),
                                        }}
                                    ></div>
                                </td>
                            </tr>
                        </>
                    )}
                    {consultation?.diagnosis?.icd10_codes.length > 0 && (
                        <>
                            <tr>
                                <td>ICD10 Codes</td>
                                <td>
                                    <div className="fw-semibold html-list-reset text-dark">
                                        <ul>
                                            {consultation?.diagnosis?.icd10_codes.map(
                                                (icd10Code, index) => (
                                                    <li key={'icd10' + index}>
                                                        {icd10Code.icd10_code.code} -{' '}
                                                        {icd10Code.icd10_code.description}
                                                    </li>
                                                ),
                                            )}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </>
                    )}
                </tbody>
            </table>

            {consultation?.prescriptions?.length > 0 && (
                <>
                    <FormHeader>Prescriptions</FormHeader>

                    <table className="table" style={{ width: '100%' }}>
                        <thead className="text-dark fs-4 table-success border-success">
                            <tr>
                                <th>Prescription</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            {consultation?.prescriptions?.map((prescription, index) => (
                                <tr key={'pres-' + index}>
                                    <td>
                                        <b>{prescription.inventory_name}</b>
                                        <br />
                                        <i>Sig: {prescription.sig}</i>
                                    </td>
                                    <td>{prescription.quantity}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </>
            )}

            {consultation?.vital_signs && (
                <>
                    <FormHeader>Vital Signs</FormHeader>
                    <table className="table" style={{ width: '100%' }}>
                        <thead className="text-dark fs-4 table-success border-success">
                            <tr className="text-dark">
                                <th className="text-right">
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
                                        <td className="text-right" style={{ verticalAlign: 'top' }}>
                                            <div className="text-right">{index + 1}</div>
                                        </td>
                                        <td>
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
                                        <td style={{ verticalAlign: 'top' }} className="text-dark">
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
                </>
            )}
        </div>
    );
};

export default VisitDetailsConsultation;
