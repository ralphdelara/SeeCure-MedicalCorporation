import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect } from 'react';
import { Modal } from 'react-bootstrap';
import { Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import type { Options } from '@/types/options';
import { formSubmitResponse } from '@/lib/utils';
import { addOrUpdateBillingSupplies } from '@/actions/App/Http/Controllers/BillingSuppliesController';

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

const SuppliesModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { data, setData, post, processing } = useForm<ModalFormProps>(formData);

    const submitSupplies = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateBillingSupplies().url, {
            ...formSubmitResponse('Billing Supplies'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    useEffect(() => {
        setData('id', formData.id);
        setData('name', formData.name);
        setData('cost_price', formData.cost_price);
        setData('stock', formData.stock);
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitSupplies}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Supplies</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group col-md-12">
                                <label className="form-label" htmlFor="name">
                                    Name
                                </label>
                                <Input
                                    id="name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    placeholder="ex. Gloves"
                                />
                            </div>
                            <div className="form-group col-md-12">
                                <label className="form-label" htmlFor="cost_price">
                                    Cost Price
                                </label>
                                <Input
                                    id="cost_price"
                                    value={data.cost_price}
                                    onChange={(e) => setData('cost_price', e.target.value)}
                                    placeholder="ex. 0.00"
                                />
                            </div>
                            <div className="form-group col-md-12">
                                <label className="form-label" htmlFor="stock">
                                    Stock
                                </label>
                                <Input
                                    id="stock"
                                    value={data.stock}
                                    onChange={(e) => setData('stock', e.target.value)}
                                    placeholder="ex. 0.00"
                                />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Supplies
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default SuppliesModal;
