import { Head, Link, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Fragment } from 'react';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { LaboratoryTableList } from '@/components/laboratory/list';
import {
    IconCalendarDot,
    IconGenderAgender,
    IconMail,
    IconPhone,
    IconStethoscope,
    IconTrash,
    IconUserEdit,
} from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import DeleteButton from '@/components/delete-button';
import {
    deleteLaboratory,
    getLaboratoryDetails,
} from '@/actions/App/Http/Controllers/LaboratoryController';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import { Label } from '@/components/ui/label';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';

interface InertiaProps {
    laboratoryList: {
        tableData: LaboratoryTableList[];
        pageData: Pages;
    };
}

export default function LaboratoryList() {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: 'Link', align: 'left' },
        { name: 'Tests', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };
    const { laboratoryList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = laboratoryList;

    return (
        <>
            <Head title="Laboratory List" />
            <Breadcrumbs title="Laboratory List">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100">
                        <div className="col-md-12">
                            <SearchField url={pageData.path} selectOption={selectOption} />
                            <TableList header={header} pageData={pageData}>
                                {tableData.map((item, index) => (
                                    <tr key={'laboratoryList-' + item.id}>
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
                                                                href={getPatientDetails(
                                                                    item.patient.id,
                                                                )}
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
                                            {item.consultation_id && (
                                                <Link
                                                    href={getConsultationDetails(
                                                        item.consultation_id,
                                                    )}
                                                >
                                                    <Button
                                                        rounded={true}
                                                        className="me-1"
                                                        title="Consultation Details"
                                                    >
                                                        <i>
                                                            <IconStethoscope size={18} />
                                                        </i>
                                                    </Button>
                                                </Link>
                                            )}
                                        </td>
                                        <td>
                                            {item.test_data.map((testItem, testIndex) => (
                                                <Fragment
                                                    key={
                                                        'laboratoryList-' + index + '-' + testIndex
                                                    }
                                                >
                                                    {(testIndex === 0 ||
                                                        item.test_data[testIndex - 1].type.name !==
                                                            testItem.type.name) && (
                                                        <Fragment>
                                                            <Label className="fw-semibold fs-4">
                                                                {testItem.type.name}
                                                            </Label>
                                                        </Fragment>
                                                    )}
                                                    <div>
                                                        <h6>• {testItem.test.name}</h6>
                                                    </div>
                                                </Fragment>
                                            ))}
                                        </td>
                                        <td>
                                            {item.is_completed ? (
                                                <span className="badge text-bg-success">
                                                    Completed
                                                </span>
                                            ) : (
                                                <span className="badge text-bg-danger">
                                                    Pending
                                                </span>
                                            )}
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
                                            <Link href={getLaboratoryDetails(item.id)}>
                                                <Button
                                                    rounded={true}
                                                    className="me-1"
                                                    title="Laboratory Details"
                                                >
                                                    <i>
                                                        <IconUserEdit size={18} />
                                                    </i>
                                                </Button>
                                            </Link>

                                            <DeleteButton
                                                url={deleteLaboratory(item.id).url}
                                                msg={'record'}
                                            />
                                        </td>
                                    </tr>
                                ))}
                                {tableData.length === 0 && (
                                    <tr>
                                        <td colSpan={13} className="text-danger fs-7 text-center">
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
