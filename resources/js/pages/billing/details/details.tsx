import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { useEffect, useState } from 'react';
import { useForm, usePage, Link } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formatMoney, formSubmitResponse, printDocument } from '@/lib/utils';
import React from 'react';
import { Button } from '@/components/ui/button';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/BillingController';
import TableList from '@/components/table';
import {
    IconBuildingBank,
    IconListCheck,
    IconPlus,
    IconPrescription,
    IconPrinter,
} from '@tabler/icons-react';
import { printPrescription } from '@/actions/App/Http/Controllers/PrintController';

interface InertiaProps {
    billingDetails: {
        id: string;
        details: {
            id: string;
            name: string;
            type: {
                name: string;
            };
            billing_type_id: number;
            cost_price: string | number;
            discount: string | number;
            discount_type_id: string | number;
            tax_percent: string | number;
            nett_price: string | number;
            created_by: {
                full_name: string;
            };
            last_modified_by: {
                full_name: string;
            };
            created_at: string;
            updated_at: string;
        }[];
        visit: {
            consultation: {
                id: string;
            };
        };
        total_price: number;
        total_discount: number;
        total_nett_price: number;
    };
    discountType: Options[];
}

const Details = ({ showTab }: { showTab: boolean }) => {
    const { billingDetails, discountType } = usePage().props as unknown as InertiaProps;

    const { data, setData, patch, isDirty, setDefaults } = useForm({
        id: billingDetails.id,
        total_cost_price: billingDetails.total_cost_price ?? 0,
        total_quantity: billingDetails.total_quantity ?? 0,
        total_price: billingDetails.total_price ?? 0,
        total_discount: billingDetails.total_discount ?? 0,
        total_nett_price: billingDetails.total_nett_price ?? 0,
    });

    const header = [
        { name: 'Description', className: 'sticky-left', align: 'left' },
        { name: 'Price', align: 'center' },
        { name: 'Discount', align: 'center' },
        { name: 'Discount Type', align: 'center' },
        { name: 'Tax', align: 'center' },
        { name: 'Nett Price', className: 'sticky-right', align: 'center' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
    ];

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, {
            ...formSubmitResponse('Details'),
        });
    };

    const totalValues = (tmpData: any) => {
        let totalCostPrice = 0;
        let totalQuantity = 0;
        let totalPrice = 0;
        let totalDiscount = 0;
        let totalNettPrice = 0;

        Object.values(tmpData).forEach((item) => {
            if (typeof item !== 'object' || item === null) {
                return;
            }

            // Cast 'item' so TypeScript knows it has dynamic string keys
            const product = item as Record<string, any>;

            if (!isNaN(parseFloat(product.cost_price))) {
                totalCostPrice += parseFloat(product.cost_price);
            }

            if (!isNaN(parseFloat(product.cost_price))) {
                totalQuantity += parseFloat(product.quantity);
            }

            if (!isNaN(parseFloat(product.cost_price))) {
                totalPrice += parseFloat(product.cost_price);
            }

            if (!isNaN(parseFloat(product.discount))) {
                totalDiscount += parseFloat(product.discount);
            }

            if (!isNaN(parseFloat(product.nett_price))) {
                totalNettPrice += parseFloat(product.nett_price);
            }
        });

        return {
            totalCostPrice: totalCostPrice.toFixed(2),
            totalQuantity: totalQuantity.toFixed(2),
            totalPrice: totalPrice,
            totalDiscount: totalDiscount,
            totalNettPrice: totalNettPrice,
        };
    };

    const computeNettPrice = (id: string, field: string, value: string) => {
        const parsedValue = isNaN(parseFloat(value)) ? 0.0 : value;

        setData((prevData: any) => {
            // Get the current item or fallback to empty values if it doesn't exist yet
            const currentItem = prevData[id] || {
                cost_price: '',
                quantity: '',
                total_price: '',
                discount: '',
                discount_type_id: '',
                tax_percent: '',
                nett_price: '',
            };

            // Create a fresh copy of the item and apply the new dynamic field value
            const updatedItem = {
                ...currentItem,
                [field]: parsedValue,
            };

            const allBlank =
                updatedItem.cost_price === '' &&
                updatedItem.quantity === '' &&
                updatedItem.total_price === '' &&
                updatedItem.discount === '' &&
                updatedItem.tax_percent === '' &&
                updatedItem.nett_price === '';

            // Safely parse all numbers from our updated item copy
            const cost_price = isNaN(parseFloat(updatedItem.cost_price as string))
                ? 0.0
                : parseFloat(updatedItem.cost_price as string);
            const quantity = isNaN(parseFloat(updatedItem.quantity as string))
                ? 0
                : parseFloat(updatedItem.quantity as string);
            const discount = isNaN(parseFloat(updatedItem.discount as string))
                ? 0.0
                : parseFloat(updatedItem.discount as string);
            const tax_percent = isNaN(parseFloat(updatedItem.tax_percent as string))
                ? 0.0
                : parseFloat(updatedItem.tax_percent as string);

            updatedItem.total_price = allBlank ? '' : (cost_price * quantity).toFixed(2);
            const basePrice = updatedItem.total_price - discount;
            const totalNettPrice = (basePrice * (1 + tax_percent / 100)).toFixed(2);
            updatedItem.nett_price = allBlank ? '' : totalNettPrice;

            let totals = totalValues({ ...prevData, [id]: updatedItem });

            // Return a completely fresh state object
            return {
                ...prevData,
                [id]: updatedItem,
                total_cost_price: totals.totalCostPrice,
                total_quantity: totals.totalQuantity,
                total_price: totals.totalPrice,
                total_discount: totals.totalDiscount,
                total_nett_price: totals.totalNettPrice,
            };
        });
    };

    useEffect(() => {
        const initialFields: Record<string, any> = {};
        billingDetails.details.map((item, index) => {
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
    }, [billingDetails.details]);

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={isDirty} />
                        </div>
                        <div className="me-5 text-right">
                            <Button
                                size="lg"
                                type="button"
                                className="me-2"
                                onClick={() => printDocument('billing', billingDetails.id)}
                            >
                                <IconPlus /> Add Supplies
                            </Button>
                            <Button
                                size="lg"
                                type="button"
                                className="me-2"
                                onClick={() => printDocument('billing', billingDetails.id)}
                            >
                                <IconPrinter /> Print Billing Details
                            </Button>
                            {billingDetails.visit.consultation && (
                                <Button
                                    size="lg"
                                    type="button"
                                    onClick={() =>
                                        printDocument(
                                            'prescription',
                                            billingDetails.visit.consultation.id,
                                        )
                                    }
                                >
                                    <IconPrescription />
                                    Print Prescription
                                </Button>
                            )}
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                <div className="row g-3 mb-5 w-100">
                                    <TableList header={header}>
                                        {billingDetails.details.map((item, index) => {
                                            let priceId = 'cost-price-' + item.id;
                                            let discountId = 'discount-' + item.id;
                                            let discountTypeId = 'discount-type-' + item.id;
                                            let taxPercentId = 'tax-percent-' + item.id;
                                            let nettPriceId = 'nett-price-' + item.id;
                                            return (
                                                <tr key={'detail-' + index}>
                                                    <td className="sticky-left">
                                                        <h6 className="fs-5 fw-semibold">
                                                            {item.name}
                                                        </h6>
                                                        <h6 className="fs-3 fw-normal text-wrap">
                                                            {item.type.name}
                                                        </h6>
                                                    </td>
                                                    <td>
                                                        <div className="input-group d-flex mb-3 flex-nowrap">
                                                            <span className="input-group-text">
                                                                ₱
                                                            </span>
                                                            <Input
                                                                type="text"
                                                                id={priceId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.cost_price ?? ''
                                                                }
                                                                onChange={(e) =>
                                                                    computeNettPrice(
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
                                                                    computeNettPrice(
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
                                                                computeNettPrice(
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
                                                                    computeNettPrice(
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
                                                    <td>
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
                                                </tr>
                                            );
                                        })}
                                        <tr>
                                            <td className="sticky-left">
                                                <h6 className="fs-6 fw-semibold">Total</h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_price)}
                                                </h6>
                                            </td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_discount)}
                                                </h6>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td className="text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_nett_price)}
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
