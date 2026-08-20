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

interface InertiaProps {
    patientList: {
        tableData: PatientTableList[];
        pageData: Pages;
    };
}

export default function PatientList() {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', width: '30%', align: 'left' },
        { name: 'Date of Birth • Age', width: '20%', align: 'left' },
        { name: 'Address', width: '15%', align: 'left' },
        { name: 'Contact', width: '15%', align: 'left' },
        { name: 'Status', width: '5%', align: 'left' },
        { name: '', width: '10%', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };
    const { patientList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = patientList;

    const parseAddress = (item: any) => {
        let address = '';

        address = addressSeparator(address, item.house_no);
        address = addressSeparator(address, item.street);
        address = addressSeparator(address, item.barangay?.name);
        address = addressSeparator(address, item.city?.name);
        address = addressSeparator(address, item.province?.name);

        return address;
    };

    const addressSeparator = (address: string, value: string) => {
        if (value === '' || value === null || value === undefined) {
            return address;
        }

        if (address !== '') {
            address += ', ';
        }

        address += value;

        return address;
    };

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
                            <div className="table-responsive rounded-1 mb-4 border">
                                <SearchField url={pageData.path} selectOption={selectOption} />
                                <TableList header={header} pageData={pageData}>
                                    {tableData.map((item, index) => (
                                        <tr key={'patientList-' + item.id}>
                                            <td className="text-right">
                                                <h5>{pageData.from + index}</h5>
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-center">
                                                    <img
                                                        className="rounded-circle"
                                                        width="40"
                                                        height="40"
                                                        src="../assets/images/profile/user-2.jpg"
                                                    />
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
                                                            {item.age ?? 'N/A'}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span className="fw-normal">
                                                    {parseAddress(item)}
                                                </span>
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6>
                                                            <IconPhone size={20} />
                                                        </h6>
                                                        <span className="fw-normal">
                                                            <IconMail size={20} />
                                                        </span>
                                                    </div>
                                                    <div className="ms-3">
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.contact_number ?? 'N/A'}
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
                                            <td>
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

                                                <DeleteButton
                                                    url={deletePatient(item.id).url}
                                                    msg={
                                                        'patient <b>' +
                                                        item.full_name +
                                                        '</b>.'
                                                    }
                                                />
                                            </td>
                                        </tr>
                                    ))}
                                    {tableData.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan={7}
                                                className="text-danger fs-7 text-center"
                                            >
                                                No records
                                            </td>
                                        </tr>
                                    )}
                                </TableList>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
