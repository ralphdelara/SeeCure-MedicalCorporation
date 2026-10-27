import { useState } from 'react';
import SuppliesModal from './supplies-modal';
import SaveButton from './save-button';
import { IconEdit, IconPlus } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import TableList from '@/components/table';
import { usePage } from '@inertiajs/react';
import DeleteButton from '@/components/delete-button';
import { deleteBilling } from '@/actions/App/Http/Controllers/BillingController';
import { deleteBillingSupply } from '@/actions/App/Http/Controllers/BillingSuppliesController';

const Supplies = ({ showTab }: { showTab: boolean }) => {
    const { billingDetails } = usePage().props;
    console.log(billingDetails);
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
        { name: 'Name', className: 'sticky-left', align: 'left', width: '30%' },
        { name: 'Stock', align: 'right' },
        { name: 'Cost Price', align: 'right' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'left', width: '5%' },
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
                                        {billingDetails.supplies.map((item, index) => (
                                            <tr key={'supplies-' + index}>
                                                <td>{item.name}</td>
                                                <td className="text-right">{item.stock}</td>
                                                <td className="text-right">{item.cost_price}</td>

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
                                                        <div className="ms-3">
                                                            <h6 className="fs-4 fw-semibold">
                                                                {item.last_modified_by?.full_name ??
                                                                    ''}
                                                            </h6>
                                                            <h6 className="fs-4 fw-normal">
                                                                {item.updated_at ?? ''}
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
                                                                name: item.name,
                                                                cost_price: item.cost_price,
                                                                stock: item.stock,
                                                            })
                                                        }
                                                    >
                                                        <i>
                                                            <IconEdit size={18} />
                                                        </i>
                                                    </Button>

                                                    <DeleteButton
                                                        url={deleteBillingSupply(item.id).url}
                                                        msg={'<b>' + item.name + '</b>'}
                                                        successUrl={
                                                            window.location.pathname +
                                                            window.location.search
                                                        }
                                                    />
                                                </td>
                                            </tr>
                                        ))}
                                        {billingDetails.supplies.length === 0 && (
                                            <tr>
                                                <td colSpan={6} className="text-danger text-center">
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
            </div>
        </>
    );
};

export default Supplies;
