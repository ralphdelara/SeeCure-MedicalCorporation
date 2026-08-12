import { Head, Link, usePage } from '@inertiajs/react';
import {
    IconChevronDown,
    IconEdit,
    IconStethoscope,
    IconTrash,
    IconUser,
    IconVolume,
} from '@tabler/icons-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { ConsultationList } from './types';
import { Button } from '@/components/ui/button';
import { Fragment } from 'react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';

interface InertiaProps {
    consultationList: {
        tableData: ConsultationList[];
        pageData: Pages;
    };
}

export default function Consultation() {
    const { consultationList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = consultationList;

    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient', width: '25%', align: 'left' },
        { name: 'Symptoms', width: '10%', align: 'left' },
        { name: 'Services', width: '10%', align: 'left' },
        { name: 'Doctor', width: '20%', align: 'left' },
        { name: 'Status', width: '10%', align: 'left' },
        { name: 'Action', width: '15%', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };

    const showHideDetails = (id: string) => {
        let recordDetails = document.getElementById(id + '-record');
        let iconDetails = document.getElementById(id + '-icon');

        if (recordDetails?.classList.contains('d-none')) {
            recordDetails.classList.remove('d-none');
            iconDetails?.classList.remove('rotate-180');
        } else {
            recordDetails?.classList.add('d-none');
            iconDetails?.classList.add('rotate-180');
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
                            <Fragment key={'consult-' + index}>
                                <tr>
                                    <td className="text-right">
                                        <h3>{pageData.from + index}</h3>
                                    </td>
                                    <td>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div className="round-40 rounded-circle d-flex align-items-center justify-content-center text-bg-info text-white">
                                                            <IconUser />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 className="fw-bolder ms-2">
                                                            <Link href={getPatientDetails(item.id).url}>
                                                                {item.patient.full_name}
                                                            </Link>
                                                        </h5>
                                                        <h6 className="ms-2">
                                                            {item.patient.gender?.name}
                                                        </h6>
                                                        <h6 className="ms-2">{item.patient.age}</h6>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        {item.signs_or_symptoms.map((item2, index2) => (
                                            <h6 key={'signs-or-symptoms-' + index + '-' + index2}>
                                                <span className="badge text-bg-danger">
                                                    {item2.signs_or_symptom.name}
                                                </span>
                                            </h6>
                                        ))}
                                    </td>
                                    <td>
                                        {item.types.map((item2, index2) => (
                                            <h6 key={'type-' + index + '-' + index2}>
                                                <span className="badge text-bg-secondary">
                                                    {item2.type.name}
                                                </span>
                                            </h6>
                                        ))}
                                    </td>
                                    <td>
                                        <h5 className="fw-bolder">{item.doctor.full_name}</h5>
                                        {item.doctor.professions.map((item2, index2) => (
                                            <span
                                                key={'prof-' + index + '-' + index2}
                                                className="me-2"
                                            >
                                                {item2.profession.suffix}
                                            </span>
                                        ))}
                                        <br/>
                                        {item.created_at}
                                    </td>
                                    <td>
                                        <span className="badge text-bg-secondary">
                                            {item.status.name}
                                        </span>
                                    </td>
                                    <td>
                                        <Button
                                            rounded={true}
                                            className="me-1 mb-1"
                                            title="Call Patient"
                                        >
                                            <i>
                                                <IconVolume size={18} />
                                            </i>
                                        </Button>
                                        <Button
                                            rounded={true}
                                            className="me-1 mb-1"
                                            title="Edit Queue Details"
                                        >
                                            <i>
                                                <IconEdit size={18} />
                                            </i>
                                        </Button>
                                        <br />
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

                                {item.types.map((item2, index2) => (
                                    <Fragment key={'details-main-' + index + '-' + index2}>
                                        <tr
                                            id={'details-' + index + '-' + index2}
                                            onClick={(e) => showHideDetails(e.currentTarget.id)}
                                        >
                                            <td colSpan={8} className="cursor-pointer text-center">
                                                <h5 className="fw-bolder">
                                                    {item2.type.name} Details{' '}
                                                    <IconChevronDown
                                                        id={
                                                            'details-' +
                                                            index +
                                                            '-' +
                                                            index2 +
                                                            '-icon'
                                                        }
                                                    />
                                                </h5>
                                            </td>
                                        </tr>
                                        <tr id={'details-' + index + '-' + index2 + '-record'}>
                                            <td colSpan={8} className="text-center">
                                                <h6>No {item2.type.name} Record</h6>
                                            </td>
                                        </tr>
                                    </Fragment>
                                ))}
                            </Fragment>
                        ))}
                        {tableData.length === 0 && (
                            <tr>
                                <td colSpan={9} className="text-center">
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
