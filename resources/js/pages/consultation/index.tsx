import { Head, Link, usePage } from '@inertiajs/react';
import { IconStethoscope, IconTrash, IconVolume, IconVolumeOff } from '@tabler/icons-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { ConsultationList } from './types';
import { Button } from '@/components/ui/button';
import { Fragment, useState } from 'react';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import {
    callOutPatient,
    getConsultationDetails,
} from '@/actions/App/Http/Controllers/ConsultationController';
import { fetchUrl } from '@/lib/utils';

interface InertiaProps {
    consultationList: {
        tableData: ConsultationList[];
        pageData: Pages;
    };
}

export default function Consultation() {
    const { consultationList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = consultationList;
    const [allowCallPatient, setAllowCallPatient] = useState(true);

    const header = [
        { name: '#', align: 'right' },
        { name: 'Patient', className: 'sticky-left', align: 'left' },
        { name: 'Symptoms', align: 'left' },
        { name: 'Vital Signs', align: 'left' },
        { name: 'Attending Doctor', align: 'left' },
        { name: 'Guardian', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };

    const callPatient = async (patientName: string) => {
        if (!allowCallPatient) return;

        // Lock the button immediately BEFORE the network request starts
        setAllowCallPatient(false);

        try {
            const response = await fetchUrl(callOutPatient().url, 'POST', {
                patientName: patientName,
            });

            // Handle your response here if needed
        } catch (error) {
            console.error('Failed to call patient:', error);
            setAllowCallPatient(true);
        } finally {
            const timer = setTimeout(() => {
                setAllowCallPatient(true);
            }, 10000);
        }
    };

    return (
        <>
            <Head title="Consultation" />
            <Breadcrumbs title="Consultation">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <SearchField url={pageData.path} selectOption={selectOption} />
                    <TableList header={header} pageData={pageData}>
                        {tableData.map((item, index) => (
                            <tr key={'consult-' + index}>
                                <td className="text-right">
                                    <h5>{pageData.from + index}</h5>
                                </td>
                                <td className="sticky-left">
                                    <div className="d-block">
                                        <div className="d-flex align-items-center">
                                            <div style={{ width: '40px' }}>
                                                <img
                                                    className="rounded-circle"
                                                    width="40"
                                                    height="40"
                                                    src="../assets/images/profile/user-2.jpg"
                                                />
                                            </div>
                                            <div className="ms-3">
                                                <h6 className="fs-4 fw-semibold mb-0">
                                                    <Link
                                                        href={getPatientDetails(item.patient.id)}
                                                        className="tooltip-container"
                                                        data-title="Click to View Patient Details"
                                                    >
                                                        {item.patient.full_name}
                                                    </Link>
                                                </h6>
                                                <span className="fw-normal">
                                                    {item.patient.gender
                                                        ? item.patient.gender.name
                                                        : 'N/A'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {item.signs_or_symptoms.map((item2, index2) => (
                                        <h6 key={'signs-or-symptoms-' + item.id + '-' + index2}>
                                            <span className="badge text-bg-danger">
                                                {item2.name}
                                            </span>
                                        </h6>
                                    ))}
                                </td>
                                <td>
                                    {item.patient_vital_sign?.map((item2, index2) => (
                                        <Fragment
                                            key={
                                                'patient-' +
                                                item.patient.id +
                                                '-vitalsign-' +
                                                item2.id
                                            }
                                        >
                                            {item2.vital_sign.name !==
                                                item.patient_vital_sign[index2 - 1]?.vital_sign
                                                    .name && (
                                                <h6
                                                    className={
                                                        'fs-4 fw-semibold mb-0' +
                                                        (index2 > 0 ? ' mt-2' : '')
                                                    }
                                                >
                                                    {item2.vital_sign.name}
                                                </h6>
                                            )}
                                            <span className="fw-normal d-block">
                                                {item2.vital_sign_field.name}: <b>{item2.value}</b>{' '}
                                                {item2.vital_sign_field.unit}
                                            </span>
                                        </Fragment>
                                    )) ?? 'N/A'}
                                </td>
                                <td>
                                    <div className="d-block">
                                        <div className="d-flex align-items-center">
                                            <div style={{ width: '40px' }}>
                                                <img
                                                    className="rounded-circle"
                                                    width="40"
                                                    height="40"
                                                    src="../assets/images/profile/user-2.jpg"
                                                />
                                            </div>
                                            <div className="ms-3">
                                                <h6 className="fs-4 fw-semibold mb-0">
                                                    {item.doctor.full_name}
                                                </h6>
                                                <span className="fw-normal">
                                                    {item.doctor.specialties.map(
                                                        (item2, index2) => (
                                                            <span
                                                                key={'prof-' + index + '-' + index2}
                                                                className="me-2"
                                                            >
                                                                {item2.name}
                                                            </span>
                                                        ),
                                                    )}
                                                    {item.doctor.specialties.length === 0 &&
                                                        'General Practicioner'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div className="d-flex align-items-center">
                                        <div className="ms-3">
                                            {item.guardian_name && (
                                                <h6 className="fs-4 fw-semibold mb-0">
                                                    {item.guardian_name ?? ''}
                                                </h6>
                                            )}
                                            {item.guardian_contact_number && (
                                                <div className="fw-normal">
                                                    {item.guardian_contact_number ?? ''}
                                                </div>
                                            )}
                                            {item.guardian_email && (
                                                <div className="fw-normal">
                                                    {item.guardian_email ?? ''}
                                                </div>
                                            )}
                                            {item.guardian_relationship && (
                                                <div className="fw-normal">
                                                    {item.guardian_relationship?.name ?? ''}
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {item.is_completed ? (
                                        <span className="badge text-bg-success">Completed</span>
                                    ) : (
                                        <span className="badge text-bg-danger">Pending</span>
                                    )}
                                </td>

                                <td>
                                    <div className="d-flex align-items-start">
                                        <div>
                                            <h6 className="fs-4 fw-semibold">
                                                {item.created_by.full_name}
                                            </h6>
                                            <h6 className="fs-4 fw-normal">{item.created_at}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div className="d-flex align-items-start">
                                        <div className="ms-3">
                                            <h6 className="fs-4 fw-semibold">
                                                {item.last_modified_by?.full_name ?? ''}
                                            </h6>
                                            <h6 className="fs-4 fw-normal">
                                                {item.updated_at ?? ''}
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td className="sticky-right">
                                    <Button
                                        rounded={true}
                                        className="me-1 mb-1"
                                        title={allowCallPatient ? 'Call Patient' : 'Please wait...'}
                                        disabled={!allowCallPatient}
                                        onClick={() => callPatient(item.patient.full_name)}
                                    >
                                        <i>
                                            {allowCallPatient && <IconVolume size={18} />}
                                            {!allowCallPatient && <IconVolumeOff size={18} />}
                                        </i>
                                    </Button>
                                    <Link href={getConsultationDetails(item.id)}>
                                        <Button
                                            rounded={true}
                                            className="me-1 mb-1"
                                            title="Consultation Details"
                                        >
                                            <i>
                                                <IconStethoscope size={18} />
                                            </i>
                                        </Button>
                                    </Link>
                                    <Button variant="danger" rounded={true} className="mb-1">
                                        <i>
                                            <IconTrash size={18} />
                                        </i>
                                    </Button>
                                </td>
                            </tr>
                        ))}
                        {tableData.length === 0 && (
                            <tr>
                                <td colSpan={10} className="fs-7 text-danger text-center">
                                    No records
                                </td>
                            </tr>
                        )}
                    </TableList>
                </div>
            </div>
        </>
    );
}
