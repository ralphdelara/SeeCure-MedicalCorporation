import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconEdit, IconFilePlus, IconPencilPlus, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import VitalSignsModal, { ModalFormProps } from './vital-signs-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import { deleteVitalSigns } from '@/actions/App/Http/Controllers/ConsultationController';
import SaveConsultation from './complete-consultation';

interface InertiaProps {
    consultationDetails: {
        id: string;
        vitalSign: {
            id: string;
            inventory_id: string;
            inventory_name: string;
            quantity: string;
            dosage: string;
            created_by: {
                full_name: string;
            };
            created_at: string;
            last_modified_by: {
                full_name: string;
            };
            updated_at: string;
        }[];
    };
}

const VitalSigns = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails, vitalSigns } = usePage().props as unknown as InertiaProps;
    const { patient_vital_sign } = consultationDetails;
    console.log(vitalSigns);
    const [formShow, setFormShow] = useState(false);
    const defaultData = {
        id: '',
        consultation_id: consultationDetails.id,
        vital_sign_id: '',
        vital_sign_field_id: '',
        value: '',
    };
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });

    const header = [
        { name: '#', align: 'right' },
        { name: 'Vital Sign', align: 'left' },
        { name: 'Value', align: 'left' },
        { name: 'Unit', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        {
            name: '',
            align: 'right',
        },
    ];

    const toggleModal = (formType: string, formData: ModalFormProps | null) => {
        setFormShow(true);
        setModalDetails({
            formType: formType,
            formData: formData ?? modalDetails.formData,
        });
    };

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <VitalSignsModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                    />
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row mb-5 w-100">
                                <div className="d-flex justify-content-between mt-2 mb-2">
                                    <SaveConsultation />
                                    <Button
                                        size="lg"
                                        onClick={() => toggleModal('Add', defaultData)}
                                    >
                                        <i>
                                            <IconPlus className="me-1" />
                                        </i>
                                        Add Vital Signs
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Vital Signs</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {patient_vital_sign.map((item, index) => (
                                        <tr key={'vitalSigns-' + item.id}>
                                            <td className="text-right">{index + 1}</td>
                                            <td>
                                                {item.vital_sign_field.name}<br/>
                                                {item.vital_sign.name}
                                            </td>
                                            <td>{item.value}</td>
                                            <td>{item.vital_sign_field.unit}</td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.created_by?.full_name ?? ''}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.created_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.last_modified_by?.full_name ?? ''}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.updated_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <Button
                                                    rounded={true}
                                                    title="Edit"
                                                    className="me-2"
                                                    onClick={() =>
                                                        toggleModal('Update', {
                                                            id: item.id,
                                                            consultation_id: consultationDetails.id,
                                                            vital_sign_id: item.vital_sign_id,
                                                            vital_sign_field_id: item.vital_sign_field_id,
                                                            value: item.value,
                                                            vital_sign_name: item.vital_sign.name,
                                                            vital_sign_field_name: item.vital_sign_field.name,
                                                            unit: item.vital_sign_field.unit,
                                                        })
                                                    }
                                                >
                                                    <i>
                                                        <IconEdit size={18} />
                                                    </i>
                                                </Button>

                                                <DeleteButton
                                                    url={deleteVitalSigns(item.id).url}
                                                    msg={'<b>' + item.vital_sign.name + ' ' + item.vital_sign_field.name + '</b>'}
                                                    successUrl={
                                                        window.location.pathname +
                                                        window.location.search
                                                    }
                                                />
                                            </td>
                                        </tr>
                                    ))}
                                    {patient_vital_sign.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan={7}
                                                className="fs-7 text-danger text-center"
                                            >
                                                No record
                                            </td>
                                        </tr>
                                    )}
                                </TableList>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default VitalSigns;
