import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { addOrUpdateStockMovement } from '@/actions/App/Http/Controllers/InventoryController';
import { formSubmitResponse } from '@/lib/utils';

interface PageProps {
    inventoryDetails: {
        id: string;
    };
    inventoryCategories: Options[];
    stockMovementTypeOptions: Options[];
    supplierOptions: Options[];
}

interface ModalProps {
    formType: string;
    formData: ModalFormProps;
    formShow: boolean;
    setFormShow: any;
}

export interface ModalFormProps {
    stock_movement_id: string;
    stock_movement_type_id: string;
    cost_price: string;
    current_stock: string;
    quantity: string;
    new_stock: string;
    total_price: string;
    lot_no: string;
    manufacture_date: string;
    expiry_date: string;
    supplier: string;
    reference_no: string;
}

const StockMovementModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { stockMovementTypeOptions, supplierOptions, inventoryDetails } = usePage()
        .props as unknown as PageProps;

    const { data, setData, post, processing, errors, setDefaults } = useForm({...formData});

    const submitStockMovement = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateStockMovement(inventoryDetails.id).url, {
            ...formSubmitResponse('Stock Movement'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    const computeTotalPrice = () => {
        const costPrice = parseFloat(data.cost_price);
        const quantity = parseFloat(data.quantity);

        if (isNaN(costPrice) || isNaN(quantity)) {
            return 0;
        }

        return (costPrice * quantity).toFixed(2);
    };

    const computeNewStock = () => {
        const currentStock = parseFloat(data.current_stock);
        const quantity = parseFloat(data.quantity);

        if (isNaN(currentStock) || isNaN(quantity)) {
            return 0;
        }

        if (data.stock_movement_type_id === '1') {
            // Stock In
            return currentStock + quantity;
        } else if (data.stock_movement_type_id === '2') {
            return currentStock - quantity;
        } else {
            return 0;
        }
    };

    useEffect(() => {
        setData('stock_movement_id', formData.stock_movement_id);
        setData('stock_movement_type_id', formData.stock_movement_type_id);
        setData('cost_price', formData.cost_price);
        setData('current_stock', formData.current_stock);
        setData('quantity', formData.quantity);
        setData('new_stock', formData.new_stock);
        setData('total_price', formData.total_price);
        setData('lot_no', formData.lot_no);
        setData('manufacture_date', formData.manufacture_date);
        setData('expiry_date', formData.expiry_date);
        setData('supplier', formData.supplier);
        setData('reference_no', formData.reference_no);
        console.log(formData);
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitStockMovement}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Stock Movement</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group">(*) Mandatory</div>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label
                                            className="form-label"
                                            htmlFor="stock_movement_type_id"
                                        >
                                            Movement Type *
                                        </label>
                                        <Select
                                            id="stock_movement_type_id"
                                            value={data.stock_movement_type_id}
                                            onChange={(e) =>
                                                setData('stock_movement_type_id', e.target.value)
                                            }
                                            type=""
                                            options={stockMovementTypeOptions}
                                            required={true}
                                        />
                                        <InputError
                                            message={errors.stock_movement_type_id}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="cost_price">
                                            Cost Price *
                                        </label>

                                        <Input
                                            value={data.cost_price}
                                            id="cost_price"
                                            onChange={(e) => setData('cost_price', e.target.value)}
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 200"
                                            maxLength={10}
                                            required={true}
                                        />
                                        <InputError message={errors.cost_price} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="quantity">
                                            Quantity *
                                        </label>

                                        <Input
                                            value={data.quantity}
                                            onChange={(e) => setData('quantity', e.target.value)}
                                            id="quantity"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 24"
                                            maxLength={10}
                                            required={true}
                                        />
                                        <InputError message={errors.quantity} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="lot_no">
                                            Lot No *
                                        </label>

                                        <Input
                                            value={data.lot_no}
                                            onChange={(e) => setData('lot_no', e.target.value)}
                                            id="lot_no"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. A123456789"
                                            maxLength={20}
                                            required={true}
                                        />
                                        <InputError message={errors.lot_no} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="manufacture_date">
                                            Manufacture Date *
                                        </label>

                                        <Input
                                            value={data.manufacture_date}
                                            onChange={(e) =>
                                                setData('manufacture_date', e.target.value)
                                            }
                                            id="manufacture_date"
                                            type="date"
                                            className="form-control"
                                            placeholder="ex. 24"
                                            required={true}
                                        />
                                        <InputError
                                            message={errors.manufacture_date}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="expiry_date">
                                            Expiry Date *
                                        </label>

                                        <Input
                                            value={data.expiry_date}
                                            onChange={(e) => setData('expiry_date', e.target.value)}
                                            id="expiry_date"
                                            type="date"
                                            className="form-control"
                                            placeholder="ex. 24"
                                            required={true}
                                        />
                                        <InputError message={errors.expiry_date} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="total_price">
                                            Total Price{' '}
                                            <span className="fs-1">(auto generated)</span>
                                        </label>

                                        <Input
                                            value={computeTotalPrice()}
                                            id="total_price"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 20"
                                            maxLength={10}
                                            readOnly={true}
                                        />
                                        <InputError message={errors.total_price} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="current_stock">
                                            Current Stock{' '}
                                            <span className="fs-1">(auto generated)</span>
                                        </label>

                                        <Input
                                            value={data.current_stock}
                                            id="current_stock"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 40"
                                            maxLength={5}
                                            readOnly={true}
                                        />
                                        <InputError
                                            message={errors.current_stock}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="new_stock">
                                            New Stock <span className="fs-1">(auto generated)</span>
                                        </label>

                                        <Input
                                            value={computeNewStock()}
                                            id="new_stock"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 20"
                                            maxLength={5}
                                            readOnly={true}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="supplier">
                                            Supplier
                                        </label>
                                        <Input
                                            value={data.supplier}
                                            id="supplier"
                                            onChange={(e) => setData('supplier', e.target.value)}
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. ABC TRADING"
                                            maxLength={50}
                                        />
                                        <InputError message={errors.supplier} className="mt-2" />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="reference_no">
                                            Reference No
                                        </label>

                                        <Input
                                            value={data.reference_no}
                                            onChange={(e) =>
                                                setData('reference_no', e.target.value)
                                            }
                                            id="reference_no"
                                            type="text"
                                            className="form-control"
                                            placeholder="ex. 123456789"
                                            maxLength={20}
                                        />
                                        <InputError
                                            message={errors.reference_no}
                                            className="mt-2"
                                        />
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
                            {formType} Stock Movement
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default StockMovementModal;
