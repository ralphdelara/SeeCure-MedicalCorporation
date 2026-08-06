import { useForm } from '@inertiajs/react';
import { IconPlus, IconUserDown, IconUserPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import toast, { Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import { queuePatient } from '@/routes';
import ConsultationForm from './consultation-form';
import ExistingPatientForm from './existing-patient-form';
import NewPatientForm from './new-patient-form';
import SignsOrSymptomsForm from './signs-or-symptoms-form';
import type { AddPatientFormTypes } from './types';
import VitalSignsForm from './vital-signs-form';

const QueuePatient = () => {
    const [showModal, setShowModal] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm<AddPatientFormTypes>({
        form_type: 'existing',
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

        vital_signs: {},
        philhealth_id: '',

        guardian_name: '',
        guardian_contact_number: '',
        guardian_email: '',
        doctor_id: '',
        consultation_types_id: [],
        signs_or_symptoms_id: [],
    });

    const submitQueue = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(queuePatient().url, {
            onSuccess: () => {
                if (data.form_type === 'new') {
                    toast.success('Patient has been added.');
                }

                setShowModal(false);
                reset();
                toast.success('Patient placed in queue.');
            },
            onError: () => {
                toast.error('Failed to add patient.');
            },
        });
    };

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} /> Queue Patient
            </Button>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitQueue}>
                    <Modal.Header closeButton>
                        <Modal.Title>Queue Patient</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix" role="application">
                            <div className="steps clearfix">
                                <ul role="tablist">
                                    <li
                                        role="tab"
                                        onClick={() => setData('form_type', 'existing')}
                                        className={
                                            'first w-50' +
                                            (data.form_type === 'existing' ? ' current' : ' done')
                                        }
                                    >
                                        <a href="#" className="fs-4 fw-bold">
                                            <IconUserDown className="me-2" />
                                            Existing Patient
                                        </a>
                                    </li>
                                    <li
                                        role="tab"
                                        onClick={() => setData('form_type', 'new')}
                                        className={
                                            'w-50' +
                                            (data.form_type === 'new' ? ' current' : ' done')
                                        }
                                    >
                                        <a href="#" className="fs-4 fw-bold">
                                            <IconUserPlus className="me-2" />
                                            New Patient
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div className="content clearfix">
                                {data.form_type === 'existing' && (
                                    <ExistingPatientForm
                                        data={data}
                                        setData={setData}
                                        errors={errors}
                                    />
                                )}
                                {data.form_type === 'new' && (
                                    <NewPatientForm data={data} setData={setData} errors={errors} />
                                )}

                                <ConsultationForm data={data} setData={setData} errors={errors} />
                                <SignsOrSymptomsForm
                                    data={data}
                                    setData={setData}
                                    errors={errors}
                                />
                                <VitalSignsForm data={data} setData={setData} />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            Queue Patient
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default QueuePatient;
