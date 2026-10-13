import { Head, Link, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { PatientTableList } from '@/components/patient/list';
import { deletePatient, getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import {
    IconCalendarDot,
    IconGenderAgender,
    IconMail,
    IconPhone,
    IconTrash,
    IconUserEdit,
} from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import NewPatient from './new-patient-modal';
import DeleteButton from '@/components/delete-button';
import personDefault from '@/assets/images/profile/person-default.png';

interface InertiaProps {
    patientList: {
        tableData: PatientTableList[];
        pageData: Pages;
    };
    isAdmin: boolean;
}

export default function PatientList() {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: 'Control No', align: 'left' },
        { name: 'Date of Birth • Age', align: 'left' },
        { name: 'Contact', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: 'Civil Status', align: 'left' },
        { name: 'Nationality', align: 'left' },
        { name: 'Occupation', align: 'left' },
        { name: 'Address', align: 'left' },
        { name: 'Senior Citizen ID', align: 'left' },
        { name: 'PWD ID', align: 'left' },
        { name: 'Philhealth ID', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };
    const { patientList, isAdmin } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = patientList;

    return (
        <>
            <Head title="Patient List" />
            <Breadcrumbs title="Patient List">
                <NewPatient />
            </Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100">
                        <div className="col-md-12">
                            <SearchField url={pageData.path} selectOption={selectOption} />
                            <TableList header={header} pageData={pageData}>
                                {tableData.map((item, index) => (
                                    <tr key={'patientList-' + item.id}>
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
                                                            src={personDefault}
                                                        />
                                                    </div>
                                                    <div className="ms-3">
                                                        <h6 className="fs-4 fw-semibold mb-0">
                                                            <Link
                                                                href={getPatientDetails(item.id)}
                                                                className="tooltip-container"
                                                                data-title="Click to View Patient Details"
                                                            >
                                                                {item.full_name}
                                                            </Link>
                                                        </h6>
                                                        <span className="fw-normal">
                                                            {item.gender ? item.gender.name : 'N/A'}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="text-right">
                                            <h5>{item.control_no}</h5>
                                        </td>
                                        <td>
                                            <div className="d-flex align-items-start">
                                                <div>
                                                    <h6>
                                                        <IconCalendarDot size={20} />
                                                    </h6>
                                                    <span className="fw-normal">
                                                        <IconGenderAgender size={20} />
                                                    </span>
                                                </div>
                                                <div className="ms-3">
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.date_of_birth ?? 'N/A'}
                                                    </h6>
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.age_computed ?? item.age ?? 'N/A'}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div className="d-flex align-items-start">
                                                <div>
                                                    <h6>
                                                        <IconPhone size={20} />
                                                    </h6>
                                                    <h6>
                                                        <IconPhone size={20} />
                                                    </h6>
                                                    <span className="fw-normal">
                                                        <IconMail size={20} />
                                                    </span>
                                                </div>
                                                <div className="ms-3">
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.contact_number1 ?? 'N/A'}
                                                    </h6>
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.contact_number2 ?? 'N/A'}
                                                    </h6>
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.email ?? 'N/A'}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span className="badge text-bg-secondary">
                                                {item.status.name}
                                            </span>
                                        </td>
                                        <td>{item.civil_status?.name ?? ''}</td>
                                        <td>{item.nationality?.name ?? ''}</td>
                                        <td>{item.occupation}</td>
                                        <td>
                                            <span className="fw-normal">{item.full_address}</span>
                                        </td>
                                        <td>
                                            <span className="fw-normal">
                                                {item.senior_citizen_id}
                                            </span>
                                        </td>
                                        <td>
                                            <span className="fw-normal">{item.pwd_id}</span>
                                        </td>
                                        <td>
                                            <span className="fw-normal">{item.philhealth_id}</span>
                                        </td>
                                        <td>
                                            <div className="d-flex align-items-start">
                                                <div>
                                                    <h6 className="fs-4 fw-semibold">
                                                        {item.created_by.full_name}
                                                    </h6>
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.created_at}
                                                    </h6>
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
                                            <Link href={getPatientDetails(item.id)}>
                                                <Button
                                                    rounded={true}
                                                    className="me-1"
                                                    title="Patient Details"
                                                >
                                                    <i>
                                                        <IconUserEdit size={18} />
                                                    </i>
                                                </Button>
                                            </Link>

                                            {/*isAdmin && item.control_no !== 0 && (
                                                <DeleteButton
                                                    url={deletePatient(item.id).url}
                                                    msg={'patient <b>' + item.full_name + '</b>.'}
                                                />
                                            )*/}
                                                <DeleteButton
                                                    url={deletePatient(item.id).url}
                                                    msg={'patient <b>' + item.full_name + '</b>.'}
                                                />
                                        </td>
                                    </tr>
                                ))}
                                {tableData.length === 0 && (
                                    <tr>
                                        <td colSpan={14} className="text-danger fs-7 text-center">
                                            No records
                                        </td>
                                    </tr>
                                )}
                            </TableList>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
