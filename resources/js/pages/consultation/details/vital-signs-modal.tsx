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
import { addOrUpdateVitalSigns } from '@/actions/App/Http/Controllers/ConsultationController';

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
    id: string;
    consultation_id: string;
    inventory_id: string;
    inventory_name: string;
    quantity: string;
    sig: string;
}

const VitalSignsModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { consultationDetails, vitalSigns } = usePage().props as unknown as PageProps;
    const [fields, setFields] = useState([]);

    const dataFields = {
        consultation_id: consultationDetails.id,
        patient_id: consultationDetails.visit.patient_id,
    };

    const { data, setData, post, processing, errors } = useForm<ModalFormProps>(formData);

    const submitVitalSigns = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateVitalSigns().url, {
            ...formSubmitResponse('VitalSigns'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    const toggleVitalSign = (id: string) => {
        if (id === '') {
            setFields([]);
        }

        vitalSigns.map((item, index) => {
            if (item.id === parseInt(id)) {
                const allowedFields = [];
                item.fields.map((field, fieldIndex) => {
                    if ((dataFields?.id ?? '') !== '') {
                        if (Object.hasOwn(dataFields, 'field_id_' + field.id)) {
                            allowedFields.push(field);
                        }
                    } else {
                        allowedFields.push(field);
                        dataFields['field_id_' + field.id] = '';
                    }
                });
                setFields(allowedFields);
                dataFields['vital_sign_id'] = item.id;
            }
        });

        setData(dataFields);
    };

    useEffect(() => {
        dataFields['id'] = formData.id;
        dataFields['vital_sign_id'] = formData.vital_sign_id;
        dataFields['field_id_' + formData.field_id] = formData.value;

        toggleVitalSign(formData?.vital_sign_id ?? '');

        setData(dataFields);
    }, [formData]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitVitalSigns}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Vital Signs</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group">(*) Mandatory</div>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="inventory_name">
                                            Vital Sign *
                                        </label>

                                        <Select
                                            value={data.vital_sign_id}
                                            onChange={(e) => toggleVitalSign(e.target.value)}
                                            options={vitalSigns}
                                        />
                                        <InputError
                                            message={errors.vital_sign_id}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>
                                {fields.map((field, fieldIndex) => (
                                    <div className="col-md-12" key={'vitalsigns-' + fieldIndex}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor={'field_id_' + field.id}>
                                                {field.name} ({field.unit})
                                            </label>

                                            <Input
                                                value={data['field_id_' + field.id]}
                                                onChange={(e) =>
                                                    setData('field_id_' + field.id, e.target.value)
                                                }
                                                id={'field_id_' + field.id}
                                                type="number"
                                                className="form-control"
                                                placeholder="ex. 24"
                                                maxLength={100}
                                                required={true}
                                                step="0.0001"
                                            />
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Vital Signs
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default VitalSignsModal;
