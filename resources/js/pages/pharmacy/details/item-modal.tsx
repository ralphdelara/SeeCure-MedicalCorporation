import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { computeNettPrice, fetchUrl, formSubmitResponse } from '@/lib/utils';
import { addItem } from '@/actions/App/Http/Controllers/PharmacyController';
import { Select } from '@/components/ui/select';
import TableList from '@/components/table';
import { getSmallInventoryList } from '@/actions/App/Http/Controllers/InventoryController';
import { IconMoneybag, IconSearch } from '@tabler/icons-react';
import { InputIcon } from '@/components/ui/input-icon';

interface ModalProps {
    formType: string;
    formData: ModalFormProps;
    formShow: boolean;
    setFormShow: any;
}

export interface ModalFormProps {
    id: string;
    pharmacy_id: string;
}

const PharmacyItemModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { pharmacyDetails, inventoryCategories, discountType } = usePage().props;

    const { data, setData, post, processing } = useForm<ModalFormProps>(formData);
    const [selectedSupply, setSelectedSupply] = useState('');

    const [keyword, setKeyword] = useState('');
    const [inventoryList, setInventoryList] = useState<InventoryListProps[]>([]);
    const [categoryId, setCategoryId] = useState('');
    const searchInventory = async (categoryId?: string) => {
        const response = await fetchUrl(getSmallInventoryList().url, 'GET', {
            keyword: keyword,
            category_id: categoryId ?? '',
        });

        setInventoryList(response);
    };

    const selectInventory = (id: string, name: string, cost_price: string) => {
        setData('inventory_id', id);
        setData('name', name);
        computeNettPrice(setData, data, 'cost_price', cost_price);
    };

    const updateInventoryCategory = (categoryId: string) => {
        setCategoryId(categoryId);
        searchInventory(categoryId);
    };

    const submitItem = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addItem().url, {
            ...formSubmitResponse('Inventory Item'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    useEffect(() => {
        searchInventory();
    }, []);

    useEffect(() => {
        setData('id', formData.id);
        setData('pharmacy_id', formData.pharmacy_id);
        setData('inventory_id', formData.inventory_id);
        setData('name', formData.name);
        setData('cost_price', formData.cost_price);
        setData('quantity', formData.quantity);
        setData('total_price', formData.total_price);
        setData('discount', formData.discount);
        setData('discount_type_id', formData.discount_type_id);
        setData('tax_percent', formData.tax_percent);
        setData('tax_amount', formData.tax_amount);
        setData('nett_price', formData.nett_price);
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal size="xl" show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitItem}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Inventory Item</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="row">
                                <div className="col-md-8">
                                    <h5 className="fw-semibold mt-2">
                                        Selected Item: {data.name ?? 'None'}
                                    </h5>
                                    <div className="input-group d-flex flex-nowrap">
                                        <Input
                                            value={keyword}
                                            className="form-control form-control-lg"
                                            placeholder="Enter keyword"
                                            maxLength={100}
                                            onChange={(e) => setKeyword(e.target.value)}
                                            onKeyDown={(e) => {
                                                if (e.key === 'Enter') {
                                                    e.preventDefault(); // Prevents the PARENT form from submitting
                                                    searchInventory(); // Calls your fetch logic directly
                                                }
                                            }}
                                        />
                                        <Select
                                            type="Category"
                                            value={categoryId}
                                            onChange={(e) =>
                                                updateInventoryCategory(e.target.value)
                                            }
                                            options={inventoryCategories}
                                        />
                                        <Button
                                            variant="default"
                                            type="button"
                                            onClick={() => searchInventory()}
                                            disabled={processing}
                                        >
                                            <IconSearch />
                                        </Button>
                                    </div>

                                    <TableList
                                        header={[
                                            {
                                                name: 'Stock',
                                                align: 'left',
                                            },
                                            { name: 'Inventory', align: 'left' },
                                            { name: 'Category', align: 'left' },
                                        ]}
                                        floatScrollbar={false}
                                    >
                                        {inventoryList.map((item, index) => (
                                            <tr
                                                onClick={() =>
                                                    selectInventory(
                                                        item.id,
                                                        item.name,
                                                        item.cost_price,
                                                    )
                                                }
                                                className={
                                                    'cursor-pointer' +
                                                    (item.id === data.inventory_id
                                                        ? ' border-success border-2'
                                                        : '')
                                                }
                                                key={'inventoryList-' + index}
                                            >
                                                <td>{item.stock}</td>
                                                <td>{item.name}</td>
                                                <td>{item.category.name}</td>
                                            </tr>
                                        ))}
                                        {inventoryList.length === 0 && (
                                            <tr>
                                                <td
                                                    colSpan={4}
                                                    className="fs-5 text-danger text-center"
                                                >
                                                    No records
                                                </td>
                                            </tr>
                                        )}
                                    </TableList>
                                </div>
                                <div className="col-md-4">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="cost_price">
                                            Cost Price *
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">₱</span>
                                            <Input
                                                type="number"
                                                step="0.0001"
                                                id="cost_price"
                                                value={data.cost_price}
                                                className="form-control"
                                                onChange={(e) =>
                                                    computeNettPrice(
                                                        setData,
                                                        data,
                                                        'cost_price',
                                                        e.target.value,
                                                    )
                                                }
                                                required={true}
                                                placeholder="0.00"
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="quantity">
                                            Quantity *
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">#</span>
                                            <Input
                                                type="number"
                                                step="0.0001"
                                                id="quantity"
                                                value={data.quantity}
                                                className="form-control"
                                                onChange={(e) =>
                                                    computeNettPrice(
                                                        setData,
                                                        data,
                                                        'quantity',
                                                        e.target.value,
                                                    )
                                                }
                                                required={true}
                                                placeholder="0.00"
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="total_price">
                                            Total Price *
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">₱</span>
                                            <Input
                                                type="number"
                                                value={data.total_price}
                                                className="form-control"
                                                required={true}
                                                readOnly={true}
                                                placeholder="(auto compute)"
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="discount">
                                            Discount
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">₱</span>
                                            <Input
                                                type="number"
                                                step="0.0001"
                                                id="discount"
                                                value={data.discount}
                                                className="form-control"
                                                onChange={(e) =>
                                                    computeNettPrice(
                                                        setData,
                                                        data,
                                                        'discount',
                                                        e.target.value,
                                                    )
                                                }
                                                placeholder="0.00"
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="discount_type_id">
                                            Discount Type
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <Select
                                                id="discount_type_id"
                                                value={data.discount_type_id}
                                                onChange={(e) =>
                                                    computeNettPrice(
                                                        setData,
                                                        data,
                                                        'discount_type_id',
                                                        e.target.value,
                                                    )
                                                }
                                                type=""
                                                style={{ width: '110px' }}
                                                options={discountType}
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="tax_percent">
                                            Tax
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">%</span>
                                            <Input
                                                type="number"
                                                step="0.0001"
                                                id="tax_percent"
                                                value={data.tax_percent}
                                                className="form-control"
                                                onChange={(e) =>
                                                    computeNettPrice(
                                                        setData,
                                                        data,
                                                        'tax_percent',
                                                        e.target.value,
                                                    )
                                                }
                                                placeholder="0.00"
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="nett_price">
                                            Nett Price
                                        </label>
                                        <div className="input-group d-flex flex-nowrap">
                                            <span className="input-group-text">₱</span>
                                            <Input
                                                type="number"
                                                step="0.0001"
                                                id="nett_price"
                                                value={data.nett_price}
                                                className="form-control"
                                                required={true}
                                                readOnly={true}
                                                placeholder="(auto compute)"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Inventory Item
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default PharmacyItemModal;
