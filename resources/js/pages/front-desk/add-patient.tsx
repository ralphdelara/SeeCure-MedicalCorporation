import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form, useForm } from '@inertiajs/react';
import { IconPlus, IconUserDown, IconUserPlus } from '@tabler/icons-react';
import axios from 'axios';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';

interface AddPatientForm {
    last_name: string;
    first_name: string;
    middle_name: string;
    consult_reason: string;
}

export default () => {
    const [showModal, setShowModal] = useState(false);
    const [formType, setFormType] = useState('existing');
    const { data, setData, post, processing, errors } = useForm<AddPatientForm>({
        last_name: '',
        first_name: '',
        middle_name: '',
        consult_reason: '',
    });

    const searchPatient = () => {

    }

    const submitForm = () => {
        return true;
    }

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} /> Add Patient
            </Button>

            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Add Patient</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="wizard clearfix" role="application">
                        <div className="steps clearfix">
                            <ul role="tablist">
                                <li role="tab"
                                    onClick={() => setFormType('existing')}
                                    className={'first w-50' + (formType === 'existing' ? ' current' : ' done')}>
                                    <a href="#" className="fs-4 fw-bold">
                                        <IconUserDown className="me-2" />
                                        Existing Patient
                                    </a>
                                </li>
                                <li role="tab"
                                    onClick={() => setFormType('new')}
                                    className={'w-50' + (formType === 'new' ? ' current' : ' done')}>
                                    <a href="#" className="fs-4 fw-bold">
                                        <IconUserPlus className="me-2" />
                                        New Patient
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div className="content clearfix">
                            {formType === 'existing' && (
                                <section role="tabpanel" className="body current">
                                    <p>
                                        <label className="form-label" htmlFor="search-patient">Search Patient *</label>
                                        <input id="search-patient" type="text" className="form-control" placeholder="ex. Juan Cruz" />

                                        <label className="form-label" htmlFor="text-3">HTML Content *</label>
                                        <textarea id="text-3" rows={5} className="form-control"></textarea>
                                    </p>
                                    <p>(*) Mandatory</p>
                                </section>
                            )}
                            {formType === 'new' && (
                                <section role="tabpanel" className="body current">
                                    <p>
                                        <label className="form-label" htmlFor="last-name">Last Name *</label>
                                        <br />
                                        <input id="last-name" type="text" className="form-control" placeholder="ex. Cruz" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="first-name">First Name *</label>
                                        <br />
                                        <input id="first-name" type="text" className="form-control" placeholder="ex. Juan" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="middle-name">Middle Name</label>
                                        <br />
                                        <input id="middle-name" type="text" className="form-control" placeholder="ex. Carlos" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="middle-name">Date Of Birth</label>
                                        <br />
                                        <input id="middle-name" type="text" className="form-control" placeholder="ex. Carlos" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="contact-number-1">Contact Number 1</label>
                                        <br />
                                        <input id="contact-number-1" type="text" className="form-control" placeholder="ex. 09xxxxxxxxx" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="contact-number-2">Contact Number 2</label>
                                        <br />
                                        <input id="contact-number-2" type="text" className="form-control" placeholder="ex. 09xxxxxxxxx" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="email">Email</label>
                                        <br />
                                        <input id="email" type="text" className="form-control" placeholder="ex. xxxxxx@gmail.com" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="occupation">Occupation</label>
                                        <br />
                                        <input id="occupation" type="text" className="form-control" placeholder="ex. Construction Worker" />
                                    </p>

                                    <p>
                                        <label className="form-label" htmlFor="house-no">House No</label>
                                        <br />
                                        <input id="house-no" type="text" className="form-control" placeholder="ex. 123" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="street">Street</label>
                                        <br />
                                        <input id="street" type="text" className="form-control" placeholder="ex. Street A" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="barangay">Barangay</label>
                                        <br />
                                        <input id="barangay" type="text" className="form-control" placeholder="ex. Barangay A" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="city">Town/City</label>
                                        <br />
                                        <input id="city" type="text" className="form-control" placeholder="ex. Town/City" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="province">Province</label>
                                        <br />
                                        <input id="province" type="text" className="form-control" placeholder="ex. Province" />
                                    </p>
                                    <p>
                                        <label className="form-label" htmlFor="province">Province</label>
                                        <br />
                                        <input id="province" type="text" className="form-control" placeholder="ex. Province" />
                                    </p>
                                    <p>(*) Mandatory</p>
                                </section>
                            )}

                            <section role="tabpanel" className="body current">
                                <div className="form-group">

                                    <Label htmlFor="consult-reason" className="form-label">Consult Reason</Label>
                                    <Input
                                        id="consult-reason"
                                        type="consult-reason"
                                        name="consult-reason"
                                        className="form-control"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="consult-reason"
                                        aria-describedby="consult-reason"
                                        placeholder="ex. Fever"
                                    />
                                    <InputError message={errors.consult_reason} />
                                </div>
                            </section>
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="light" onClick={() => setShowModal(false)}>
                        Close
                    </Button>
                    <Button variant="default" onClick={() => setShowModal(false)}>
                        Save Changes
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
}