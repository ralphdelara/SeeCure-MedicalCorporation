import { Head, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { BillingTableList } from '@/components/billing/list';
import { Options } from '@/types/options';
import inventoryDefault from '@/assets/images/inventory/inventory-default.png';
import { formatMoney } from '@/lib/utils';

interface InertiaProps {}

export default function Billing() {
    const selectOption: Options[] = [];
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Name', className: 'sticky-left', align: 'left' },
        { name: 'Cost Price', align: 'left' },
        { name: 'Stock', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];
    const { billingSuppliesList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = billingSuppliesList;

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
                                    <tr key={'billingSuppliesList-' + item.id}>
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
                                                            src={inventoryDefault}
                                                        />
                                                    </div>
                                                    <div className="ms-3">{item.name}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{formatMoney(item.cost_price)}</td>
                                        <td>{item.stock}</td>
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
                                        <td className="sticky-right"></td>
                                    </tr>
                                ))}
                                {tableData.length === 0 && (
                                    <tr>
                                        <td colSpan={7} className="text-danger fs-7 text-center">
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
