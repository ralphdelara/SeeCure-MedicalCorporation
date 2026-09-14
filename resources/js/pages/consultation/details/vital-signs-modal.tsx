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
    dosage: string;
}

interface InventoryListProps {
    id: string;
    name: string;
    unit: Options;
    stock: number;
    category: Options;
}

const VitalSignsModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { consultationDetails, vitalSigns } = usePage().props as unknown as PageProps;
    const [fields, setFields] = useState([]);

    const { data, setData, post, processing, errors } = useForm<ModalFormProps>(formData);

    const submitVitalSigns = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();
/*
        post(addOrUpdateVitalSigns().url, {
            ...formSubmitResponse('VitalSigns'),
            onFinish: () => {
                setFormShow(false);
            },
        });*/
    };

    const toggleVitalSign = (id: string) => {
        setData('vital_sign_id', id);

        if (id === '') {
            setFields([]);
        }

        vitalSigns.map((item, index) => {
            if (item.id === parseInt(id)) {
                setFields(item.fields);
            }
        });
    };

    useEffect(() => {
        toggleVitalSign(formData?.vital_sign_id ?? '');
        setData('patient_vital_sign_id', formData.patient_vital_sign_id);
        setData('consultation_id', formData.consultation_id);
        setData('vital_sign_id', formData.vital_sign_id);
        setData('vital_sign_field_ids', formData.vital_sign_field_ids);
        setData('vital_sign_field_values', formData.vital_sign_field_values);
        setData('vital_sign_name', formData.vital_sign_name);
        setData('unit', formData.unit);
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
                                            message={errors.inventory_name}
                                            className="mt-2"
                                        />
                                    </div>
                                </div>
                                {fields.map((field, fieldIndex) => (
                                    <div className="col-md-12">
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="dosage">
                                                {field.name} ({field.unit})
                                            </label>

                                            <Input
                                                value={data['vital_sign_field_id_' + field.id]}
                                                onChange={(e) =>
                                                    setData(
                                                        'vital_sign_field_id_' + field.id,
                                                        e.target.value,
                                                    )
                                                }
                                                id="value"
                                                type="number"
                                                className="form-control"
                                                placeholder="ex. 24"
                                                maxLength={100}
                                                required={true}
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
