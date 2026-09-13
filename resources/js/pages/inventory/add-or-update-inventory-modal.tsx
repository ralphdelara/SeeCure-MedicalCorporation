import { useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import { addOrUpdateInventory } from '@/actions/App/Http/Controllers/InventoryController';
import { Button } from '@/components/ui/button';
import NewInventoryForm from '@/components/inventory/new-inventory-form';
import { AddOrUpdateInventoryDetailsFormProps } from '@/components/inventory/new-inventory';

interface ModalProps {
    showModal: boolean;
    setShowModal: React.Dispatch<React.SetStateAction<boolean>>;
    modalData?: AddOrUpdateInventoryDetailsFormProps;
}

const AddOrUpdateModal = ({ showModal, setShowModal, modalData }: ModalProps) => {
    const { data, setData, post, processing, errors, reset } = useForm<AddOrUpdateInventoryDetailsFormProps>({
        id: 0,
        name: '',
        inventory_category_id: '',
        inventory_unit_id: '',
        stock: '',
        cost_price: '',
        selling_price_vat_exclusive: '',
        selling_price_vat_inclusive: '',
        markup_amount: '',
        markup_percent: '',
        vat_percent: 0,
        vat_amount: '',
        photo: '',
    });

    useEffect(() => {
        if (modalData) {
            (Object.entries(modalData) as [keyof AddOrUpdateInventoryDetailsFormProps, any][]).map(([key, val]) => {
                setData(key, val);
            });
        }
    }, [modalData, setData]);

    const submitInventory = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateInventory().url, {
            onSuccess: () => {
                toast.success('Inventory has been added.');

                setShowModal(false);
                reset();
            },
            onError: () => {
                toast.error('Failed to add inventory.');
            },
        });
    };

    const formType = data.id != 0 ? 'Update' : 'Add';

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitInventory}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Inventory</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix" role="application">
                            <NewInventoryForm data={data} setData={setData} errors={errors}/>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Inventory
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default AddOrUpdateModal;
