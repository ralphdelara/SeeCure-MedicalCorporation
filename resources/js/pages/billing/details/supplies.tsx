import { useState } from 'react';
import SuppliesModal from './supplies-modal';
import SaveButton from './save-button';
import { IconPlus } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import TableList from '@/components/table';

const Supplies = ({ showTab }: { showTab: boolean }) => {
    const [formShow, setFormShow] = useState(false);
    const defaultSuppliesData = {
        id: '',
        name: '',
        cost_price: '',
        stock: '',
    };
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultSuppliesData },
    });

    const toggleModal = (formType: string, formData: ModalFormProps | null) => {
        setFormShow(true);
        setModalDetails({
            formType: formType,
            formData: formData ?? modalDetails.formData,
        });
    };

    const header = [
        { name: 'Name', className: 'sticky-left', align: 'left' },
        { name: 'Stock', align: 'center' },
        { name: 'Price', align: 'center' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
    ];
    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <SuppliesModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                    />
                    <div className="me-4">
                        <SaveButton type="Details" isDirty={false} hideSaveButton={true} />
                    </div>
                    <div className="me-5 text-right">
                        <Button
                            size="lg"
                            type="button"
                            className="me-2"
                            onClick={() => toggleModal('Add', defaultSuppliesData)}
                        >
                            <IconPlus /> Add Supplies
                        </Button>
                    </div>

                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row mb-5 w-100">
                                <div className="d-flex justify-content-between mt-2 mb-2">
                                    <TableList header={header}>
                                        <tr></tr>
                                    </TableList>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Supplies;
