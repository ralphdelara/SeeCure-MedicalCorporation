import { useForm, usePage } from '@inertiajs/react';
import { IconPlus, IconUserDown, IconUserPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import toast, { Toaster } from 'react-hot-toast';
import { queue } from '@/actions/App/Http/Controllers/FrontDeskController';
import { Button } from '@/components/ui/button';
import ExistingPatientForm from './existing-patient-form';
import SignsOrSymptomsForm from '../../../components/consultation/signs-or-symptoms-form';
import type { QueuePatientDetailsFormProps } from './types';
import VitalSignsForm from '../../../components/vital-signs/vital-signs-form';
import NewPatientForm from '@/components/patient/new-patient-form';
import MedicalServices from './medical-services';
import InputError from '@/components/input-error';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';

const QueuePatient = () => {
    const [showModal, setShowModal] = useState(false);
    const { priorityTypeOptions } = usePage().props as unknown as {
        priorityTypeOptions: Options[];
    };

    const { data, setData, post, processing, errors, reset } =
        useForm<QueuePatientDetailsFormProps>({
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
            senior_citizen_id: '',

            house_no: '',
            street: '',
            barangay_id: '',
            city_id: '16',
            province_id: '1',

            photo: '',

            vital_signs: {},
            philhealth_id: '',

            guardian_name: '',
            guardian_contact_number: '',
            guardian_email: '',
            guardian_relationship_id: '',
            doctor_id: '',
            has_consultation: 0,
            has_laboratory: 0,
            has_radiology: 0,
            is_emergency: 0,
            signs_or_symptoms_id: [],
            priority_type_ids: [],

            laboratory_id: '',
            laboratory_package_id: '',
            other_test_ids: [],

            radiology_test_ids: [],
        });

    const submitQueue = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(queue().url, {
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

    const updatePriorityTypes = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.checked) {
            setData('priority_type_ids', [...data.priority_type_ids, parseInt(e.target.value)]);
        } else {
            setData(
                'priority_type_ids',
                data.priority_type_ids.filter((item) => item !== parseInt(e.target.value)),
            );
        }
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

                                <div className="row px-4">
                                    <div className="col-md-12">
                                        <div className="form-check form-check-inline">
                                            <input
                                                className="form-check-input success"
                                                type="checkbox"
                                                id="is_emergency"
                                                value="1"
                                                onChange={(e) =>
                                                    setData(
                                                        'is_emergency',
                                                        e.currentTarget.checked ? 1 : 0,
                                                    )
                                                }
                                                name="is_emergency"
                                                checked={data.is_emergency === 1}
                                            />
                                            <Label
                                                className="form-check-label"
                                                htmlFor="is_emergency"
                                            >
                                                <h5 className="fw-semibold">Emergency?</h5>
                                            </Label>
                                        </div>
                                    </div>
                                    <InputError message={errors.is_emergency} className="mt-2" />
                                </div>

                                <div className="row mt-3 px-4">
                                    <div className="col-md-12">
                                        <Label htmlFor="priorityType" className="form-label fs-5">
                                            Priority Type
                                        </Label>
                                    </div>
                                    {priorityTypeOptions.map((item, index) => (
                                        <div
                                            className={'col-md-4'}
                                            key={'signsOrSymptoms-' + index}
                                        >
                                            {item.id !== 3 && (
                                                <div className="form-check form-check-inline">
                                                    <input
                                                        className="form-check-input success"
                                                        type="checkbox"
                                                        id={'priority_type_ids-' + index}
                                                        value={item.id}
                                                        onChange={(e) => updatePriorityTypes(e)}
                                                        name="signs-or-symptoms"
                                                        checked={data.priority_type_ids.includes(
                                                            item.id,
                                                        )}
                                                    />
                                                    <label
                                                        className="form-check-label"
                                                        htmlFor={'priority_type_ids-' + index}
                                                    >
                                                        {item.name}
                                                    </label>
                                                </div>
                                            )}
                                        </div>
                                    ))}
                                    <InputError
                                        message={errors.priority_type_ids}
                                        className="mt-2"
                                    />
                                </div>

                                <MedicalServices data={data} setData={setData} errors={errors} />
                                {data.has_consultation === 1 && (
                                    <SignsOrSymptomsForm
                                        data={data}
                                        setData={setData}
                                        errors={errors}
                                    />
                                )}
                                <VitalSignsForm data={data} setData={setData} />
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
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
