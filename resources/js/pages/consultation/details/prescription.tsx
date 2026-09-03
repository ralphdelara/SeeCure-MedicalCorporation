import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconEdit, IconFilePlus, IconPencilPlus, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import PrescriptionModal, { ModalFormProps } from './prescription-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import { deletePrescription } from '@/actions/App/Http/Controllers/ConsultationController';
import Pagination from '@/components/pagination';

interface InertiaProps {
    consultationDetails: {
        id: string;
        prescriptions: {
            id: string;
            product_id: string;
            product_name: string;
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
        product_id: '',
        product_name: '',
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
                            <div className="row w-100 mb-5">
                                <div className="mt-2 text-right">
                                    <Button size="lg" onClick={() => toggleModal('Add', defaultData)}>
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
                                            <td>{item.product_name}</td>
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
                                                            product_id: item.product_id,
                                                            product_name: item.product_name,
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
                                                    msg={'<b>' + item.product_name + '</b>'}
                                                    successUrl={window.location.pathname + window.location.search}
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
