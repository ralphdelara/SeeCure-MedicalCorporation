import { Head, usePage } from '@inertiajs/react';
import { IconEdit, IconPackage } from '@tabler/icons-react';
import { useState } from 'react';
import { deleteProduct } from '@/actions/App/Http/Controllers/PharmacyController';
import { Breadcrumbs } from '@/components/breadcrumbs';
import DeleteButton from '@/components/delete-button';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import { Button } from '@/components/ui/button';
import { formatMoney } from '@/lib/utils';
import type { Options } from '@/types/options';
import type { Pages } from '@/types/pagination';
import AddProduct from './add-or-update-product';
import type { AddProductForm, ProductList } from './add-or-update-product/types';
import AddOrUpdateModal from './add-or-update-product-modal';

interface InertiaProps {
    productList: {
        tableData: ProductList[];
        pageData: Pages;
    };
    productCategoryOptions: Options[];
}

export default function Pharmacy() {
    const { productList, productCategoryOptions } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = productList;
    const [showModal, setShowModal] = useState(false);
    const [modalData, setModalData] = useState<AddProductForm>();

    const header = [
        { name: '#', align: 'right' },
        { name: 'Product', width: '25px', align: 'left' },
        { name: 'Category', align: 'left' },
        { name: 'Stock', align: 'right' },
        { name: 'Cost Price', align: 'right' },
        { name: 'Selling Price', align: 'right' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    const toggleEditModal = (data: AddProductForm) => {
        setShowModal(true);
        setModalData(data);
    };

    const selectOption = {
        options: productCategoryOptions,
        type: 'All Category',
    };

    return (
        <>
            <Head title="Pharmacy" />
            <Breadcrumbs title="Pharmacy">
                <AddProduct />
            </Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <SearchField url={pageData.path} selectOption={selectOption} />
                    <TableList header={header} pageData={pageData}>
                        {tableData.map((item, index) => (
                            <tr key={'product-' + index}>
                                <td className="text-right">
                                    <h5>{pageData.from + index}</h5>
                                </td>
                                <td style={{width: '100px'}}>
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
                                <td className="text-nowrap sticky-right">
                                    <Button
                                        variant="primary"
                                        rounded={true}
                                        title="Edit"
                                        className="me-2"
                                        onClick={() =>
                                            toggleEditModal({
                                                id: item.id,
                                                name: item.name,
                                                product_category_id: item.category.id,
                                                product_unit_id: item.unit.id,
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
                                    <Button rounded={true} className="me-2" title="View Product">
                                        <i>
                                            <IconPackage size={20} />
                                        </i>
                                    </Button>

                                    <DeleteButton
                                        url={deleteProduct(item.id).url}
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
