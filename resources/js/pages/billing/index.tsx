import { Head, Link, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { BillingTableList } from '@/components/billing/list';
import { IconReceipt, IconVolume, IconVolumeOff } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { getBillingDetails } from '@/actions/App/Http/Controllers/BillingController';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import { Options } from '@/types/options';
import personDefault from '@/assets/images/profile/person-default.png';
import { useState } from 'react';
import { fetchUrl } from '@/lib/utils';
import { callOutPatient } from '@/routes/system';

interface InertiaProps {
    billingList: {
        tableData: BillingTableList[];
        pageData: Pages;
    };
}

export default function Billing() {
    const selectOption: Options[] = [];
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: 'Billing Type', align: 'left' },
        { name: 'Emergency', align: 'left' },
        { name: 'Priority', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];
    const { billingList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = billingList;
    const [allowCallPatient, setAllowCallPatient] = useState(true);

    const callPatient = async (patientName: string) => {
        if (!allowCallPatient) return;

        // Lock the button immediately BEFORE the network request starts
        setAllowCallPatient(false);

        try {
            const response = await fetchUrl(callOutPatient().url, 'POST', {
                patientName: patientName,
                department: 'Billing',
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
            <Head title="Billing" />
            <Breadcrumbs title="Billing">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100">
                        <div className="col-md-12">
                            <SearchField url={pageData.path} selectOption={selectOption} />
                            <TableList header={header} pageData={pageData}>
                                {tableData.map((item, index) => (
                                    <tr key={'billingList-' + item.id}>
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
                                                        {item.visit.patient ? (
                                                            <>
                                                                <h6 className="fs-4 fw-semibold mb-0">
                                                                    <Link
                                                                        href={getPatientDetails(
                                                                            item.visit.patient.id,
                                                                        )}
                                                                        className="tooltip-container"
                                                                        data-title="Click to View Patient Details"
                                                                    >
                                                                        {
                                                                            item.visit.patient
                                                                                .full_name
                                                                        }
                                                                    </Link>
                                                                </h6>
                                                                <span className="fw-normal">
                                                                    {item.visit.patient.gender
                                                                        ? item.visit.patient.gender
                                                                              .name
                                                                        : 'N/A'}
                                                                </span>
                                                            </>
                                                        ) : (
                                                            <h5>WALK IN</h5>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {item.details.map((detail, detailIndex) => (
                                                <h6
                                                    className="fs-4 fw-semibold mb-0"
                                                    key={'detail-' + index + '-' + detailIndex}
                                                >
                                                    {detail.name}
                                                </h6>
                                            ))}
                                        </td>
                                        <td>
                                            {item.visit.is_emergency && (
                                                <span className="badge bg-success">Yes</span>
                                            )}
                                            {!item.visit.is_emergency && (
                                                <span className="badge bg-danger">No</span>
                                            )}
                                        </td>
                                        <td>
                                            {item.visit.priority_types.map(
                                                (priority, priorityIndex) => (
                                                    <>
                                                        {priorityIndex > 0 && <br />}
                                                        <span
                                                            className={
                                                                'badge bg-info' +
                                                                (priorityIndex > 0 ? ' mt-1' : '')
                                                            }
                                                        >
                                                            {priority.name}
                                                        </span>
                                                    </>
                                                ),
                                            )}
                                            {item.visit.priority_types.length === 0 && (
                                                <span className="badge bg-danger">None</span>
                                            )}
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
                                            <Button
                                                rounded={true}
                                                className="me-1"
                                                title={
                                                    allowCallPatient
                                                        ? 'Call Patient'
                                                        : 'Please wait...'
                                                }
                                                disabled={!allowCallPatient}
                                                onClick={() =>
                                                    callPatient(item.visit.patient.full_name)
                                                }
                                            >
                                                <i>
                                                    {allowCallPatient && <IconVolume size={18} />}
                                                    {!allowCallPatient && (
                                                        <IconVolumeOff size={18} />
                                                    )}
                                                </i>
                                            </Button>

                                            <Link href={getBillingDetails(item.id)}>
                                                <Button
                                                    rounded={true}
                                                    className="me-1"
                                                    title="Billing Details"
                                                >
                                                    <i>
                                                        <IconReceipt size={18} />
                                                    </i>
                                                </Button>
                                            </Link>
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
