import { Head, Link, usePage } from '@inertiajs/react';
import { IconEdit, IconEyeCancel, IconPackage } from '@tabler/icons-react';
import { useState } from 'react';
import {
    deleteInventory,
    getInventoryDetails,
    hideItem,
    showItem,
} from '@/actions/App/Http/Controllers/InventoryController';
import { Breadcrumbs } from '@/components/breadcrumbs';
import DeleteButton from '@/components/delete-button';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import { Button } from '@/components/ui/button';
import { formatMoney } from '@/lib/utils';
import type { Options } from '@/types/options';
import type { Pages } from '@/types/pagination';
import AddInventory from './add-or-update-inventory';
import type { AddInventoryForm, InventoryList } from './add-or-update-inventory/types';
import AddOrUpdateModal from './add-or-update-inventory-modal';
import inventoryDefault from '@/assets/images/inventory/inventory-default.png';
import ConfirmButton from '@/components/confirm-button';

interface InertiaProps {
    inventoryList: {
        tableData: InventoryList[];
        pageData: Pages;
    };
    inventoryCategoryOptions: Options[];
    listType: string;
}

export default function Inventory() {
    const { inventoryList, inventoryCategoryOptions, listType } = usePage()
        .props as unknown as InertiaProps;
    const { tableData, pageData } = inventoryList;
    const [showModal, setShowModal] = useState(false);
    const [modalData, setModalData] = useState<AddInventoryForm>();

    const header = [
        { name: '#', align: 'right' },
        { name: 'Inventory • unit', className: 'sticky-left', width: '25px', align: 'left' },
        { name: 'Category', align: 'left' },
        { name: 'Stock', align: 'right' },
        { name: 'Cost Price', align: 'right' },
        { name: 'Selling Price', align: 'right' },
        { name: 'Added by', align: 'right' },
        { name: 'Last Modified By', align: 'right' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    const toggleEditModal = (data: AddInventoryForm) => {
        setShowModal(true);
        setModalData(data);
    };

    const selectOption = {
        options: inventoryCategoryOptions,
        type: 'All Category',
    };

    return (
        <>
            <Head title="Inventory" />
            <Breadcrumbs title="Inventory">
                <AddInventory />
            </Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <SearchField url={pageData.path} selectOption={selectOption} />
                    <TableList header={header} pageData={pageData}>
                        {tableData.map((item, index) => (
                            <tr key={'inventory-' + index}>
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
                                            <div className="ms-3">
                                                <h6
                                                    className="fs-4 fw-semibold mb-0 text-wrap"
                                                    style={{ width: '300px' }}
                                                >
                                                    <Link
                                                        href={getInventoryDetails(item.id)}
                                                        className="tooltip-container"
                                                        data-title="Click to View Inventory Details"
                                                    >
                                                        {item.name}
                                                    </Link>
                                                </h6>
                                                <span className="fw-normal">{item.unit.name}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td className="text-left">
                                    <h6 className="text-wrap" style={{ width: '200px' }}>
                                        {item.category.name}
                                    </h6>
                                </td>
                                <td className={'text-right'}>
                                    <h6
                                        className={parseFloat(item.stock) <= 0 ? 'text-danger' : ''}
                                    >
                                        {item.stock}
                                    </h6>
                                </td>
                                <td className="text-right">
                                    <h6>{formatMoney(item.cost_price)}</h6>
                                </td>
                                <td className="text-right">
                                    <h6>{formatMoney(item.selling_price_vat_inclusive)}</h6>
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
                                    <Link
                                        href={getInventoryDetails(item.id)}
                                        className="tooltip-container"
                                        data-title="Click to View Inventory Details"
                                    >
                                        <Button rounded={true} className="me-2">
                                            <i>
                                                <IconPackage size={20} />
                                            </i>
                                        </Button>
                                    </Link>

                                    <ConfirmButton
                                        requestMethod="PATCH"
                                        url={
                                            listType !== 'hidden-items'
                                                ? hideItem(item.id).url
                                                : showItem(item.id).url
                                        }
                                        msg={
                                            'This will ' +
                                            (listType !== 'hidden-items' ? 'hide' : 'show') +
                                            ' the item <b>' +
                                            item.name +
                                            '</b>'
                                        }
                                        variant={listType !== 'hidden-items' ? 'danger' : 'default'}
                                        title={listType !== 'hidden-items' ? 'Hide' : 'Show'}
                                        successTitle="Updated!"
                                        successMsg="The record has been updated."
                                        successUrl={
                                            window.location.pathname + window.location.search
                                        }
                                        rounded={true}
                                    >
                                        <i>
                                            <IconEyeCancel size={20} />
                                        </i>
                                    </ConfirmButton>
                                    {/*<DeleteButton
                                        url={deleteInventory(item.id).url}
                                        msg={
                                            '<b>' +
                                            item.name +
                                            '</b> also the stock movement records'
                                        }
                                    />*/}
                                </td>
                            </tr>
                        ))}
                        {tableData.length === 0 && (
                            <tr>
                                <td colSpan={11} className="text-center">
                                    No records
                                </td>
                            </tr>
                        )}
                    </TableList>
                </div>
            </div>
            <AddOrUpdateModal
                showModal={showModal}
                setShowModal={setShowModal}
                modalData={modalData}
            />
        </>
    );
}
