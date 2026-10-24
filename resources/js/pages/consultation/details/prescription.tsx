import { Head, useForm, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import {
    IconDeviceFloppy,
    IconEdit,
    IconFilePlus,
    IconPencilPlus,
    IconPlus,
    IconPrescription,
    IconTrash,
} from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import PrescriptionModal, { ModalFormProps } from './prescription-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import {
    deletePrescription,
    updateDetails,
} from '@/actions/App/Http/Controllers/ConsultationController';
import Pagination from '@/components/pagination';
import CompleteConsultation from './complete-consultation';
import { printDocument } from '@/lib/utils';
import TableCounter from '@/components/table-counter';
import { Input } from '@/components/ui/input';
import FormHeader from '@/components/ui/form-header';

interface InertiaProps {
    consultationDetails: {
        id: string;
        prescriptions: {
            id: string;
            inventory_id: string;
            inventory_name: string;
            quantity: string;
            sig: string;
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
        sig: '',
    };
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });
    const { data, setData, patch } = useForm({
        id: consultationDetails.id,
        prescription_remarks: consultationDetails.prescription_remarks ?? '',
    });

    const header = [
        { name: '#', align: 'right' },
        { name: 'Medicine • Sig', align: 'left', className: 'sticky-left' },
        { name: 'Quantity', align: 'right' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        {
            name: '',
            width: '15%',
            align: 'right',
            className: 'sticky-right',
        },
    ];

    const toggleModal = (formType: string, formData: ModalFormProps | null) => {
        setFormShow(true);
        setModalDetails({
            formType: formType,
            formData: formData ?? modalDetails.formData,
        });
    };

    const submitPrescriptionRemarks = (e) => {
        e.preventDefault();

        patch(updateDetails().url);
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
                                    <CompleteConsultation />
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
                                    <div className="text-right">
                                        <Button
                                            size="lg"
                                            type="button"
                                            onClick={() =>
                                                printDocument(
                                                    'prescription',
                                                    consultationDetails.id,
                                                )
                                            }
                                        >
                                            <IconPrescription />
                                            Print Prescription
                                        </Button>
                                    </div>
                                </div>
                                <TableCounter table={prescriptions} tableTitle="Prescription" />
                                <TableList header={header} hasPage={false}>
                                    {prescriptions.map((item, index) => (
                                        <tr key={'prescription-' + item.id}>
                                            <td className="text-right">{index + 1}</td>
                                            <td className="sticky-left">
                                                <div className="d-flex align-items-center">
                                                    <div className="ms-3">
                                                        <h6
                                                            className="fs-4 fw-semibold mb-0 text-wrap"
                                                            style={{ width: '350px' }}
                                                        >
                                                            {item.inventory_name}
                                                        </h6>
                                                        <span
                                                            className="fw-normal"
                                                            style={{ width: '300px' }}
                                                        >
                                                            {item.sig}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
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
                                            <td className="sticky-right">
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
                                                            sig: item.sig,
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
                                <TableCounter table={prescriptions} tableTitle="Prescription" />
                            </div>
                            <form onSubmit={submitPrescriptionRemarks} className="mb-5">
                                <FormHeader align="left">Remarks</FormHeader>
                                <Input
                                    value={data.prescription_remarks}
                                    onChange={(e) =>
                                        setData('prescription_remarks', e.target.value)
                                    }
                                />
                                <Button size="lg" className="mt-2">
                                    <IconDeviceFloppy /> Save Remarks
                                </Button>
                            </form>
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Prescription;
