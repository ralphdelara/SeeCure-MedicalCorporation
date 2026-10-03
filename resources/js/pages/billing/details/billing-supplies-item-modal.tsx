import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { Options } from '@/types/options';
import { formSubmitResponse } from '@/lib/utils';
import {
    addBillingSuppliesItem,
    addOrUpdateBillingSupplies,
} from '@/actions/App/Http/Controllers/BillingSuppliesController';

interface ModalProps {
    formType: string;
    formData: ModalFormProps;
    formShow: boolean;
    setFormShow: any;
}

export interface ModalFormProps {
    id: string;
    consultation_id: string;
}

const BillingSuppliesModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { billingDetails } = usePage().props;

    const { data, setData, post, processing } = useForm<ModalFormProps>(formData);
    const [selectedSupply, setSelectedSupply] = useState('');

    const submitBillingSuppliesItem = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addBillingSuppliesItem().url, {
            ...formSubmitResponse('Billing Supplies'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    useEffect(() => {
        setData('id', formData.id);
        setData('billing_id', formData.billing_id);
        setData('billing_supplies_id', formData.billing_supplies_id);
        setData('name', formData.name);
        setData('cost_price', formData.cost_price);
        setData('quantity', formData.quantity);
        setData('total_price', formData.total_price);
    }, [formData]);

    const selectBillingSupply = (e) => {
        const selectedValue = e.target.value;
        setSelectedSupply(selectedValue);

        const selectedOption = e.target.selectedOptions[0];

        if (selectedValue === '') {
            setData('name', '');
            setData('billing_supplies_id', '');
            setData('cost_price', '');
            setData('quantity', 1);
            setData('total_price', '');
        } else {
            setData('name', selectedOption.dataset.itemName);
            setData('billing_supplies_id', selectedValue);
            setData('cost_price', selectedOption.dataset.costPrice);
            setData('quantity', 1);
            setData('total_price', selectedOption.dataset.costPrice);
        }
    };

    const calculateTotalPrice = (value: string, column: string) => {
        setData(column as keyof typeof data, value);

        if (column === 'cost_price') {
            setData('total_price', value * data.quantity);
        }

        if (column === 'quantity') {
            setData('total_price', value * data.cost_price);
        }
    };

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitBillingSuppliesItem}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Billing Supplies</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group col-md-12">
                                <label className="form-label" htmlFor="select-supply">
                                    Supply
                                </label>
                                <select
                                    id="select-supply"
                                    className="form-select"
                                    value={selectedSupply}
                                    onChange={(e) => selectBillingSupply(e)}
                                >
                                    {billingDetails.supplies.map((item, index) => (
                                        <option
                                            value={item.id}
                                            key={'select-supplies-' + index}
                                            data-cost-price={item.cost_price}
                                            data-item-name={item.name}
                                        >
                                            {item.name}
                                        </option>
                                    ))}
                                    <option value="">Others</option>
                                </select>
                            </div>
                            <div
                                className={'form-group' + (selectedSupply !== '' ? ' d-none' : '')}
                            >
                                <label className="form-label" htmlFor="name">
                                    Name *
                                </label>
                                <Input
                                    type="text"
                                    id="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    placeholder="e.g. Discount or Other Items"
                                    required={true}
                                />
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="cost_price">
                                    Cost Price *
                                </label>
                                <Input
                                    type="number"
                                    step="0.0001"
                                    id="cost_price"
                                    value={data.cost_price}
                                    className="form-control"
                                    onChange={(e) =>
                                        calculateTotalPrice(e.target.value, 'cost_price')
                                    }
                                    required={true}
                                />
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="quantity">
                                    Quantity *
                                </label>
                                <Input
                                    type="number"
                                    step="0.0001"
                                    id="quantity"
                                    value={data.quantity}
                                    className="form-control"
                                    onChange={(e) =>
                                        calculateTotalPrice(e.target.value, 'quantity')
                                    }
                                    required={true}
                                />
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="total_price">
                                    Total Price *
                                </label>
                                <Input
                                    type="number"
                                    value={data.total_price}
                                    className="form-control"
                                    readOnly={true}
                                    required={true}
                                />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Billing Supplies
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default BillingSuppliesModal;
