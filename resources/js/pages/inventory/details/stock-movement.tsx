import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconEdit, IconFilePlus, IconPencilPlus, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import StockMovementModal, { ModalFormProps } from './stock-movement-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import { deleteStockMovement } from '@/actions/App/Http/Controllers/InventoryController';
import { formatMoney } from '@/lib/utils';

interface InertiaProps {
    inventoryDetails: {
        id: string;
        stock: string;
        stock_movement: {
            id: string;
            stock_movement_type: {
                id: string;
                name: string;
            };
            cost_price: string;
            current_stock: string;
            quantity: string;
            new_stock: string;
            lot_no: string;
            manufacture_date: string;
            expiry_date: string;
            inventory_name: string;
            total_price: string;
            created_by: {
                full_name: string;
            };
            supplier: string;
            reference_no: string;
            created_at: string;
            last_modified_by: {
                full_name: string;
            };
            updated_at: string;
        }[];
    };
}

const StockMovement = ({ showTab }: { showTab: boolean }) => {
    const { inventoryDetails } = usePage().props as unknown as InertiaProps;
    const { stock_movement } = inventoryDetails;
    const [formShow, setFormShow] = useState(false);
    const defaultData = {
        stock_movement_id: '',
        stock_movement_type_id: inventoryDetails.id,
        cost_price: '',
        current_stock: inventoryDetails.stock,
        quantity: '',
        new_stock: '',
        lot_no: '',
        total_price: '',
        manufacture_date: '',
        expiry_date: '',
        supplier: '',
        reference_no: '',
    };
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });

    const header = [
        { name: '#', align: 'right' },
        { name: 'Type', align: 'left' },
        { name: 'Cost Price', align: 'right' },
        { name: 'Current Stock', align: 'right' },
        { name: 'Quantity', align: 'right' },
        { name: 'New Stock', align: 'right' },
        { name: 'Total Price', align: 'right' },
        { name: 'Lot No', align: 'left' },
        { name: 'Mfg. Date', align: 'left' },
        { name: 'Exp. Date', align: 'left' },
        { name: 'Supplier', align: 'left' },
        { name: 'Reference No', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        {
            name: '',
            className: 'sticky-right',
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
                    <StockMovementModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                    />
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row mb-5 w-100">
                                <div className="d-flex justify-content-between mt-2 mb-2">
                                    <div></div>
                                    <Button
                                        size="lg"
                                        onClick={() => toggleModal('Add', defaultData)}
                                    >
                                        <i>
                                            <IconPlus className="me-1" />
                                        </i>
                                        Add Stock Movement
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Stock Movement</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {stock_movement?.map((item, index) => (
                                        <tr key={'stock_movement-' + item.id}>
                                            <td className="text-right">{index + 1}</td>
                                            <td>{item.stock_movement_type.name}</td>
                                            <td className="text-right">
                                                {formatMoney(item.cost_price)}
                                            </td>
                                            <td className="text-right">{item.current_stock}</td>
                                            <td className="text-right">{item.quantity}</td>
                                            <td className="text-right">{item.new_stock}</td>
                                            <td className="text-right">
                                                {formatMoney(item.total_price)}
                                            </td>
                                            <td>{item.lot_no}</td>
                                            <td>{item.manufacture_date}</td>
                                            <td>{item.expiry_date}</td>
                                            <td>{item.supplier}</td>
                                            <td>{item.reference_no}</td>
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
                                                            {item.last_modified_by?.full_name ??
                                                                'N/A'}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.updated_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="sticky-right">
                                                {item.stock_movement_type.id !== '3' && (
                                                    <>
                                                        <Button
                                                            rounded={true}
                                                            title="Edit"
                                                            className="me-2"
                                                            onClick={() =>
                                                                toggleModal('Update', {
                                                                    stock_movement_id: item.id,
                                                                    stock_movement_type_id:
                                                                        item.stock_movement_type.id,
                                                                    cost_price: item.cost_price,
                                                                    current_stock:
                                                                        item.current_stock,
                                                                    quantity: item.quantity,
                                                                    new_stock: item.new_stock,
                                                                    total_price: item.total_price,
                                                                    lot_no: item.lot_no ?? '',
                                                                    manufacture_date: new Date(
                                                                        item.manufacture_date,
                                                                    ).toLocaleDateString('sv-SE'),
                                                                    expiry_date: new Date(
                                                                        item.expiry_date,
                                                                    ).toLocaleDateString('sv-SE'),
                                                                    supplier: item.supplier ?? '',
                                                                    reference_no:
                                                                        item.reference_no ?? '',
                                                                })
                                                            }
                                                        >
                                                            <i>
                                                                <IconEdit size={18} />
                                                            </i>
                                                        </Button>

                                                        <DeleteButton
                                                            url={
                                                                deleteStockMovement({
                                                                    inventoryId:
                                                                        inventoryDetails.id,
                                                                    stockMovementId: item.id,
                                                                }).url
                                                            }
                                                            msg={'<b>record</b>'}
                                                            successUrl={
                                                                window.location.pathname +
                                                                window.location.search
                                                            }
                                                        />
                                                    </>
                                                )}
                                            </td>
                                        </tr>
                                    ))}
                                    {stock_movement.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan={14}
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

export default StockMovement;
