import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { useEffect, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import {
    computeNettPriceDetails,
    formatMoney,
    formSubmitResponse,
    printDocument,
} from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import {
    deletePharmacyDetail,
    updateDetails,
} from '@/actions/App/Http/Controllers/PharmacyController';
import TableList from '@/components/table';
import { Button } from '@/components/ui/button';
import { IconPlus, IconPrinter } from '@tabler/icons-react';
import PharmacyItemModal from './item-modal';
import DeleteButton from '@/components/delete-button';

interface InertiaProps {
    pharmacyDetails: {
        id: string;
        consultation_id: string;
        details: {
            id: string;
            prescription: {
                inventory_id: null | string;
                inventory_name: string;
            };
            cost_price: string;
            quantity: string;
            total_price: string;
            discount: string;
            discount_type_id: string;
            tax_percent: string;
            nett_price: string;
            created_by: {
                full_name: string;
            };
            last_modified_by: {
                full_name: string;
            };
            created_at: string;
            updated_at: string;
        }[];
        total_cost_price: string;
        total_quantity: string;
        total_price: string;
        total_discount: string;
        total_nett_price: string;
    };
    discountType: Options[];
}

const Details = ({ showTab }: { showTab: boolean }) => {
    const { pharmacyDetails, discountType } = usePage().props as unknown as InertiaProps;
    const { data, setData, patch, isDirty, setDefaults } = useForm({
        id: pharmacyDetails.id,
        total_cost_price: pharmacyDetails.total_cost_price ?? 0,
        total_quantity: pharmacyDetails.total_quantity ?? 0,
        total_price: pharmacyDetails.total_price ?? 0,
        total_discount: pharmacyDetails.total_discount ?? 0,
        total_nett_price: pharmacyDetails.total_nett_price ?? 0,
    });

    const header = [
        { name: 'Item', className: 'sticky-left', align: 'left' },
        { name: 'Cost Price', align: 'center' },
        { name: 'Quantity', align: 'center' },
        { name: 'Total Price', align: 'center' },
        { name: 'Discount', align: 'center' },
        { name: 'Discount Type', align: 'center' },
        { name: 'Tax %', align: 'center' },
        { name: 'Nett Price', className: 'sticky-right-2', align: 'center' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        { name: '', className: 'sticky-right', align: 'left' },
    ];

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, {
            ...formSubmitResponse('Details'),
        });
    };

    useEffect(() => {
        const initialFields: Record<string, any> = {};
        pharmacyDetails.details.map((item, index) => {
            initialFields[item.id] = {
                cost_price: item.cost_price ?? '',
                quantity: item.quantity ?? '',
                total_price: item.total_price ?? '',
                discount: item.discount ?? '',
                discount_type_id: item.discount_type_id ?? '',
                tax_percent: item.tax_percent ?? '',
                nett_price: item.nett_price ?? '',
            };
        });

        setData({ ...data, ...initialFields });
        setDefaults({ ...data, ...initialFields });
    }, [pharmacyDetails.details]);

    const defaultItem = {
        id: '',
        pharmacy_id: pharmacyDetails.id,
        inventory_id: '',
        name: '',
        cost_price: '',
        quantity: '',
        total_price: '',
        discount: '',
        discount_type_id: '',
        tax_percent: '',
        tax_amount: '',
        nett_price: '',
    };
    const [formShow, setFormShow] = useState(false);
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultItem },
    });
    const toggleModal = (formType: string, formData: ModalFormProps | null) => {
        setFormShow(true);
        setModalDetails({
            formType: formType,
            formData: formData ?? modalDetails.formData,
        });
    };

    useEffect(() => {
        setData('total_cost_price', pharmacyDetails.total_cost_price);
        setData('total_quantity', pharmacyDetails.total_quantity);
        setData('total_price', pharmacyDetails.total_price);
        setData('total_discount', pharmacyDetails.total_discount);
        setData('total_nett_price', pharmacyDetails.total_nett_price);
    }, [pharmacyDetails]);

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <PharmacyItemModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                    />
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={isDirty} />
                        </div>
                        <div className="d-flex justify-content-end me-5">
                            <Button
                                size="lg"
                                type="button"
                                className="me-2"
                                onClick={() => toggleModal('Add', defaultItem)}
                            >
                                <IconPlus /> Add Item
                            </Button>
                            <Button
                                size="lg"
                                type="button"
                                className="me-2"
                                onClick={() => printDocument('pharmacy', pharmacyDetails.id)}
                            >
                                <IconPrinter /> Print Pick List
                            </Button>

                            <Button
                                size="lg"
                                type="button"
                                onClick={() =>
                                    printDocument(
                                        'prescription',
                                        pharmacyDetails.visit.consultation.id,
                                    )
                                }
                            >
                                <IconPrinter />
                                Print Prescription
                            </Button>
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                <div className="row g-3 mb-5 w-100">
                                    <TableList header={header}>
                                        {pharmacyDetails.details.map((item, index) => {
                                            let costPriceId = 'cost-price-' + item.id;
                                            let quantityId = 'quantity-' + item.id;
                                            let totalPriceId = 'total-price-' + item.id;
                                            let discountId = 'discount-' + item.id;
                                            let discountTypeId = 'discount-type-' + item.id;
                                            let taxPercentId = 'tax-percent-' + item.id;
                                            let nettPriceId = 'nett-price-' + item.id;
                                            return (
                                                <tr key={'detail-' + index}>
                                                    <td className="sticky-left">
                                                        <h6
                                                            className="fs-5 fw-semibold text-wrap"
                                                            style={{ width: '300px' }}
                                                        >
                                                            {item.name}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                ₱
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={costPriceId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.cost_price ?? ''
                                                                }
                                                                onChange={(e) =>
                                                                    computeNettPriceDetails(
                                                                        setData,
                                                                        item.id,
                                                                        'cost_price',
                                                                        e.target.value,
                                                                    )
                                                                }
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                #
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={quantityId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.quantity ?? ''
                                                                }
                                                                onChange={(e) =>
                                                                    computeNettPriceDetails(
                                                                        setData,
                                                                        item.id,
                                                                        'quantity',
                                                                        e.target.value,
                                                                    )
                                                                }
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                ₱
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={totalPriceId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.total_price ?? ''
                                                                }
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                                readOnly={true}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                ₱
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={discountId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.discount ?? ''
                                                                }
                                                                onChange={(e) =>
                                                                    computeNettPriceDetails(
                                                                        setData,
                                                                        item.id,
                                                                        'discount',
                                                                        e.target.value,
                                                                    )
                                                                }
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <Select
                                                            id={discountTypeId}
                                                            value={
                                                                (
                                                                    data[
                                                                        item.id as keyof typeof data
                                                                    ] as any
                                                                )?.discount_type_id ?? ''
                                                            }
                                                            onChange={(e) =>
                                                                computeNettPriceDetails(
                                                                    setData,
                                                                    item.id,
                                                                    'discount_type_id',
                                                                    e.target.value,
                                                                )
                                                            }
                                                            type=""
                                                            style={{ width: '110px' }}
                                                            options={discountType}
                                                        />
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                %
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={taxPercentId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.tax_percent ?? ''
                                                                }
                                                                onChange={(e) =>
                                                                    computeNettPriceDetails(
                                                                        setData,
                                                                        item.id,
                                                                        'tax_percent',
                                                                        e.target.value,
                                                                    )
                                                                }
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                    </td>
                                                    <td className="sticky-right-2">
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                ₱
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={nettPriceId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.nett_price ?? ''
                                                                }
                                                                readOnly={true}
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                maxLength={10}
                                                            />
                                                        </div>
                                                    </td>
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
                                                                    {
                                                                        item.last_modified_by
                                                                            .full_name
                                                                    }
                                                                </h6>
                                                                <h6 className="fs-4 fw-normal">
                                                                    {item.updated_at}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td className="sticky-right">
                                                        <DeleteButton
                                                            url={deletePharmacyDetail(item.id).url}
                                                            msg={'item <b>' + item.name + '</b>.'}
                                                        />
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                        <tr>
                                            <td className="sticky-left">
                                                <h6 className="fs-6 fw-semibold">Total</h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_cost_price ?? '0')}
                                                </h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {data.total_quantity ?? '0'}
                                                </h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_price ?? '0')}
                                                </h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_discount ?? '0')}
                                                </h6>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td className="sticky-right-2 text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_nett_price ?? '0')}
                                                </h6>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </TableList>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

export default Details;
