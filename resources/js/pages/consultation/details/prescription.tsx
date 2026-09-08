import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconEdit, IconFilePlus, IconPencilPlus, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import PrescriptionModal, { ModalFormProps } from './prescription-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import { deletePrescription } from '@/actions/App/Http/Controllers/ConsultationController';
import Pagination from '@/components/pagination';
import SaveConsultation from './save-consultation';

interface InertiaProps {
    consultationDetails: {
        id: string;
        prescriptions: {
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

const Prescription = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails } = usePage().props as unknown as InertiaProps;
    const { prescriptions } = consultationDetails;
    const [formShow, setFormShow] = useState(false);
    const defaultData = {
        id: '',
        consultation_id: consultationDetails.id,
        inventory_id: '',
        inventory_name: '',
        quantity: '',
        dosage: '',
    };
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });

    const header = [
        { name: '#', align: 'right' },
        { name: 'Medicine', align: 'left' },
        { name: 'Dosage', align: 'left' },
        { name: 'Quantity', align: 'right' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        {
            name: '',
            width: '15%',
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
                    <PrescriptionModal
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
                                        Add Prescription
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Prescription</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {prescriptions.map((item, index) => (
                                        <tr key={'prescription-' + item.id}>
                                            <td className="text-right">{index + 1}</td>
                                            <td>{item.inventory_name}</td>
                                            <td>{item.dosage}</td>
                                            <td className="text-right">{item.quantity}</td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.created_by.full_name}
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
                                                            {item.last_modified_by.full_name}
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
                                                            inventory_id: item.inventory_id,
                                                            inventory_name: item.inventory_name,
                                                            quantity: item.quantity,
                                                            dosage: item.dosage,
                                                        })
                                                    }
                                                >
                                                    <i>
                                                        <IconEdit size={18} />
                                                    </i>
                                                </Button>

                                                <DeleteButton
                                                    url={deletePrescription(item.id).url}
                                                    msg={'<b>' + item.inventory_name + '</b>'}
                                                    successUrl={
                                                        window.location.pathname +
                                                        window.location.search
                                                    }
                                                />
                                            </td>
                                        </tr>
                                    ))}
                                    {prescriptions.length === 0 && (
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

export default Prescription;
