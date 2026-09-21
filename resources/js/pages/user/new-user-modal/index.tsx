import { addOrUpdateUser } from '@/actions/App/Http/Controllers/UserController';
import { AddOrUpdateUserDetailsFormProps } from '@/components/user/new-user';
import NewUserForm from '@/components/user/new-user-form';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/react';
import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import toast, { Toaster } from 'react-hot-toast';

const NewUser = () => {
    const { data, setData, post, processing, errors, reset } =
        useForm<AddOrUpdateUserDetailsFormProps>({
            user_id: '',
            username: '',
            password: '',
            department_ids: [],
            profession_ids: [],
            specialty_ids: [],
            position_ids: [],
            license_no: '',
            ptr_no: '',
            date_hired: '',
            date_resigned: '',
            status: true,

            last_name: '',
            first_name: '',
            middle_name: '',
            date_of_birth: '',
            gender_id: '',
            photo: '',

            contact_number: '',
            email: '',
            house_no: '',
            street: '',
            barangay_id: '',
            city_id: '16', // Numancia
            province_id: '1', // Aklan
        });

    const [showModal, setShowModal] = useState(false);

    const submitQueue = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateUser().url, {
            onSuccess: () => {
                setShowModal(false);
                reset();
                toast.success('User has been added.');
            },
            onError: () => {
                toast.error('Failed to add user.');
            },
        });
    };

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} />
                Add User
            </Button>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitQueue}>
                    <Modal.Header closeButton>
                        <Modal.Title>Add User</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix mt-0">
                            <div className="content clearfix mt-0">
                                <NewUserForm data={data} setData={setData} errors={errors} />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            Add User
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default NewUser;
