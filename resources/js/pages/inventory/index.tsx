import { Head, usePage } from '@inertiajs/react';
import { IconEdit, IconPackage } from '@tabler/icons-react';
import { useState } from 'react';
import { deleteInventory } from '@/actions/App/Http/Controllers/InventoryController';
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

interface InertiaProps {
    inventoryList: {
        tableData: InventoryList[];
        pageData: Pages;
    };
    inventoryCategoryOptions: Options[];
}

export default function Inventory() {
    const { inventoryList, inventoryCategoryOptions } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = inventoryList;
    const [showModal, setShowModal] = useState(false);
    const [modalData, setModalData] = useState<AddInventoryForm>();

    const header = [
        { name: '#', align: 'right' },
        { name: 'Inventory', width: '25px', align: 'left' },
        { name: 'Category', align: 'left' },
        { name: 'Stock', align: 'right' },
        { name: 'Cost Price', align: 'right' },
        { name: 'Selling Price', align: 'right' },
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
                                <td style={{ width: '100px' }}>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div className="round-40 rounded-circle d-flex align-items-center justify-content-center text-bg-info text-white">
                                                        <IconPackage />
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 className="ms-2">{item.name}</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td className="text-left">
                                    <h6>
                                        {item.category.name}
                                        <small>
                                            <br />
                                            {item.unit.name}
                                        </small>
                                    </h6>
                                </td>
                                <td className={'text-right'}>
                                    <h6
                                        className={parseFloat(item.stock) <= 0 ? 'text-danger' : ''}
                                    >
                                        {formatMoney(item.stock)}
                                    </h6>
                                </td>
                                <td className="text-right">
                                    <h6>{formatMoney(item.cost_price)}</h6>
                                </td>
                                <td className="text-right">
                                    <h6>{formatMoney(item.selling_price_vat_inclusive)}</h6>
                                </td>
                                <td className="sticky-right text-nowrap">
                                    <Button
                                        variant="primary"
                                        rounded={true}
                                        title="Edit"
                                        className="me-2"
                                        onClick={() =>
                                            toggleEditModal({
                                                id: item.id,
                                                name: item.name,
                                                inventory_category_id: item.category.id,
                                                inventory_unit_id: item.unit.id,
                                                stock: item.stock,
                                                cost_price: item.cost_price,
                                                selling_price_vat_exclusive:
                                                    item.selling_price_vat_exclusive,
                                                selling_price_vat_inclusive:
                                                    item.selling_price_vat_inclusive,
                                                markup_amount: item.markup_amount,
                                                markup_percent: item.markup_percent,
                                                vat_percent: item.vat_percent,
                                                vat_amount: item.vat_amount,
                                                photo: item.photo,
                                            })
                                        }
                                    >
                                        <i>
                                            <IconEdit size={20} />
                                        </i>
                                    </Button>
                                    <Button rounded={true} className="me-2" title="View Inventory">
                                        <i>
                                            <IconPackage size={20} />
                                        </i>
                                    </Button>

                                    <DeleteButton
                                        url={deleteInventory(item.id).url}
                                        msg={
                                            '<b>' +
                                            item.name +
                                            '</b> also the stock movement records'
                                        }
                                    />
                                </td>
                            </tr>
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
            <AddOrUpdateModal
                showModal={showModal}
                setShowModal={setShowModal}
                modalData={modalData}
            />
        </>
    );
}
