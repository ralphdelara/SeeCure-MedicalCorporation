import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import type { Options } from '@/types/options';
import NewLaboratoryForm from '@/components/laboratory/new-laboratory-form';
import { formSubmitResponse } from '@/lib/utils';
import { addLaboratory } from '@/actions/App/Http/Controllers/ConsultationController';
import { IconExclamationCircle, IconInfoCircle } from '@tabler/icons-react';

interface PageProps {
    consultationDetails: {
        id: string;
    };
    inventoryCategories: Options[];
}

interface ModalProps {
    formType: string;
    formData: ModalFormProps;
    formShow: boolean;
    setFormShow: any;
    hasPendingLab: boolean;
}

export interface ModalFormProps {
    laboratory_id: string;
    consultation_id: string;
    visit_id: string;
    patient_id: string;
    laboratory_package_id: string;
    other_test_ids: string[];
}

const LaboratoryModal = ({
    formShow,
    setFormShow,
    formType,
    formData,
    hasPendingLab,
}: ModalProps) => {
    const { data, setData, post, processing, errors } = useForm<ModalFormProps>(formData);

    const submitLaboratory = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addLaboratory().url, {
            ...formSubmitResponse('Laboratory'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} size="lg" onHide={() => setFormShow(false)}>
                <form onSubmit={submitLaboratory}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Laboratory</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="row">
                                <div className="col-md-12">
                                    {!hasPendingLab && (
                                        <NewLaboratoryForm data={data} setData={setData} />
                                    )}
                                    {hasPendingLab && (
                                        <h4 className="text-danger p-5 text-center">
                                            This patient has pending Laboratory Request
                                        </h4>
                                    )}
                                </div>
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        {!hasPendingLab && (
                            <Button variant="default" type="submit" disabled={processing}>
                                {formType} Laboratory
                            </Button>
                        )}
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default LaboratoryModal;
