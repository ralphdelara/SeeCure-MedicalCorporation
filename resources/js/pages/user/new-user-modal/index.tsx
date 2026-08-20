import { addOrUpdatePatient } from '@/actions/App/Http/Controllers/PatientController';
import { AddOrUpdatePatientDetailsFormProps } from '@/components/patient/new-patient';
import NewPatientForm from '@/components/patient/new-patient-form';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/react';
import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import toast, { Toaster } from 'react-hot-toast';

const NewPatient = () => {
    const { data, setData, post, processing, errors, reset } =
        useForm<AddOrUpdatePatientDetailsFormProps>({
            patient_id: '',
            last_name: '',
            first_name: '',
            middle_name: '',
            patient_suffix_id: '',
            date_of_birth: '',
            age: '',
            contact_number1: '',
            contact_number2: '',
            email: '',
            occupation: '',

            gender_id: '',
            civil_status_id: '',
            nationality_id: '',

            house_no: '',
            street: '',
            barangay_id: '',
            city_id: '',
            province_id: 1,

            photo: '',

            philhealth_id: '',
        });

    const [showModal, setShowModal] = useState(false);

    const submitQueue = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdatePatient().url, {
            onSuccess: () => {
                setShowModal(false);
                reset();
                toast.success('Patient has been added.');
            },
            onError: () => {
                toast.error('Failed to add patient.');
            },
        });
    };

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} />
                Add Patient
            </Button>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitQueue}>
                    <Modal.Header closeButton>
                        <Modal.Title>Add Patient</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix">
                            <div className="content clearfix">
                                <NewPatientForm data={data} setData={setData} errors={errors} />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            Add Patient
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default NewPatient;
