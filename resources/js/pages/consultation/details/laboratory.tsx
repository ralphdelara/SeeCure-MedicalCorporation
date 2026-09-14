import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconChecklist, IconDownload, IconEdit, IconPlus, IconTrash } from '@tabler/icons-react';
import LaboratoryModal, { ModalFormProps } from './laboratory-modal';
import { Button } from '@/components/ui/button';
import { useState } from 'react';
import LaboratoryResultsModal from './laboratory-results-modal';
import SaveConsultation from './complete-consultation';

interface InertiaProps {
    consultationDetails: {
        id: string;
        visit_id: string;
        patient_id: string;
        laboratory: {
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

const Laboratory = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails } = usePage().props as unknown as InertiaProps;
    const { laboratory } = consultationDetails;

    const [formShow, setFormShow] = useState(false);
    const [resultsShow, setResultsShow] = useState(false);
    const [resultsData, setResultsData] = useState([]);
    const [hasPendingLab, setHasPendingLab] = useState(false);
    const defaultData = {
        consultation_id: consultationDetails.id,
        visit_id: consultationDetails.visit_id,
        patient_id: consultationDetails.patient_id,
        laboratory_id: '',
        laboratory_package_id: '',
        other_test_ids: [] as string[],
    };

    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });

    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'DateTime', align: 'left' },
        { name: 'Tests', className: 'sticky-left', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: '', align: 'center' },
    ];

    const toggleModal = (formType: string, formData: ModalFormProps | null) => {
        setFormShow(true);
        setModalDetails({
            formType: formType,
            formData: formData ?? modalDetails.formData,
        });
    };

    const toggleResultsModal = (testData) => {
        setResultsShow(true);
        setResultsData(testData);
    };

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <LaboratoryModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                        hasPendingLab={hasPendingLab}
                    />
                    <LaboratoryResultsModal
                        resultsShow={resultsShow}
                        setResultsShow={setResultsShow}
                        resultsData={resultsData}
                    />
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row w-100">
                                <div className="d-flex justify-content-between mt-2 mb-2">
                                    <SaveConsultation />
                                    <Button
                                        size="lg"
                                        onClick={() => toggleModal('Add', defaultData)}
                                    >
                                        <i>
                                            <IconPlus className="me-1" />
                                        </i>
                                        Add Laboratory Request
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Laboratory</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {laboratory.map((item, index) => {
                                        if (!item.is_completed) {
                                            setHasPendingLab(true);
                                        }
                                        return (
                                        <tr key={'cons-lab-' + index}>
                                            <td className="text-right">
                                                <h5>{index + 1}</h5>
                                            </td>
                                            <td>
                                                <h5>{item.created_at}</h5>
                                            </td>
                                            <td>
                                                {item.test_data.map((testData, testIndex) => (
                                                    <h6 key={'cons-lab-'+index+'-test-' + testIndex}>{testData.test.name}</h6>
                                                ))}
                                            </td>
                                            <td>
                                                {item.is_completed ? (
                                                    <span className="badge text-bg-success">
                                                        Completed
                                                    </span>
                                                ) : (
                                                    <span className="badge text-bg-danger">
                                                        Pending
                                                    </span>
                                                )}
                                            </td>
                                            <td className="text-center">
                                                <Button
                                                    rounded={true}
                                                    className="me-1 mb-1"
                                                    title="View Results"
                                                    onClick={() => toggleResultsModal(item.test_data)}
                                                >
                                                    <i>
                                                        <IconChecklist />
                                                    </i>
                                                </Button>
                                            </td>
                                        </tr>
                                    )})}
                                    {laboratory.length === 0 && (
                                        <tr>
                                            <td colSpan={5} className="text-center fs-6 text-danger">
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

export default Laboratory;
