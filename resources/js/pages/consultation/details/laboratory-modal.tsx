import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { toast, Toaster } from 'react-hot-toast';
import { getSmallInventoryList } from '@/actions/App/Http/Controllers/InventoryController';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import type { Options } from '@/types/options';
import { IconPlus } from '@tabler/icons-react';
import TableList from '@/components/table';
import { fetchUrl, formSubmitResponse } from '@/lib/utils';
import NewLaboratoryForm from '@/components/laboratory/new-laboratory-form';
import { AddOrUpdateLaboratoryDetailsFormProps } from '@/components/laboratory/new-laboratory';

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
}

export interface ModalFormProps {
    laboratory_id: string;
    laboratory_package_id: string;
    other_test_ids: string[];
}

const LaboratoryModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { data, setData, post, processing, errors } =
        useForm<ModalFormProps>(formData);

    const submitLaboratory = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();
        /*
        post(addOrUpdateLaboratory().url, {
            ...formSubmitResponse('Laboratory'),
            onFinish: () => {
                setFormShow(false);
            },
        });*/
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
                        <NewLaboratoryForm data={data} setData={setData} /></div></div></div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Laboratory
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default LaboratoryModal;
