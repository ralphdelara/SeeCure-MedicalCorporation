import { Head, Link, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { PaymentTableList } from '@/components/payment/list';
import { IconReceipt } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { getPaymentDetails } from '@/actions/App/Http/Controllers/PaymentController';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import { Options } from '@/types/options';
import personDefault from '@/assets/images/profile/person-default.png';

interface InertiaProps {
    paymentList: {
        tableData: PaymentTableList[];
        pageData: Pages;
    };
}

export default function Payment() {
    const selectOption: Options[] = [];
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: 'Receipt No', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: 'Payment Method', align: 'left' },
        { name: 'Total Amount', align: 'left' },
        { name: 'Amount Received', align: 'left' },
        { name: 'Amount Paid', align: 'left' },
        { name: 'Amount Change', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];
    const { paymentList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = paymentList;

    return (
        <>
            <Head title="Cashier" />
            <Breadcrumbs title="Cashier">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100">
                        <div className="col-md-12">
                            <SearchField url={pageData.path} selectOption={selectOption} />
                            <TableList header={header} pageData={pageData}>
                                {tableData.map((item, index) => (
                                    <tr key={'paymentList-' + item.id}>
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
                                        <td>{item.payment ?? ''}</td>
                                        <td>{item.total_amount ?? ''}</td>
                                        <td>
                                            <span
                                                className={
                                                    'badge' +
                                                    (item.status.id === 2
                                                        ? ' text-bg-success'
                                                        : ' text-bg-danger')
                                                }
                                            >
                                                {item.status.name}
                                            </span>
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
                                            <Link href={getPaymentDetails(item.id)}>
                                                <Button
                                                    rounded={true}
                                                    className="me-1"
                                                    title="Payment Details"
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
