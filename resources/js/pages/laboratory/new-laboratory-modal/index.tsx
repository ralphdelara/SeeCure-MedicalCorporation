import { addOrUpdateLaboratory } from '@/actions/App/Http/Controllers/LaboratoryController';
import { AddOrUpdateLaboratoryDetailsFormProps } from '@/components/laboratory/new-laboratory';
import NewLaboratoryForm from '@/components/laboratory/new-laboratory-form';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/react';
import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import toast, { Toaster } from 'react-hot-toast';

const NewLaboratory = () => {
    const { data, setData, post, processing, errors, reset } =
        useForm<AddOrUpdateLaboratoryDetailsFormProps>({
            laboratory_id: '',
            laboratory_package_id: '',
            other_test_ids: [],
        });

    const [showModal, setShowModal] = useState(false);

    const submitQueue = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateLaboratory().url, {
            onSuccess: () => {
                setShowModal(false);
                reset();
                toast.success('Laboratory has been added.');
            },
            onError: () => {
                toast.error('Failed to add laboratory.');
            },
        });
    };

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} />
                Add Laboratory
            </Button>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitQueue}>
                    <Modal.Header closeButton>
                        <Modal.Title>Add Laboratory</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix">
                            <div className="content clearfix">
                                <NewLaboratoryForm data={data} setData={setData} errors={errors} />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            Add Laboratory
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default NewLaboratory;
