import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { useEffect } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formatMoney, formSubmitResponse } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/CashierController';
import TableList from '@/components/table';
import { Button } from '@/components/ui/button';
import { IconArrowLeft, IconBuildingBank } from '@tabler/icons-react';
import ConfirmButton from '@/components/confirm-button';
import { cashier } from '@/routes';
import { sendBackToBilling } from '@/routes/cashier/details';

interface InertiaProps {
    cashierDetails: {
        id: string;
        details: {
            id: string;
            name: string;
            cashier_type_id: number;
            type: {
                name: string;
            };
            cost_price: string | number;
            quantity: string | number;
            total_price: string | number;
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
        total_cost_price: number;
        total_price: number;
        total_discount: number;
        total_nett_price: number;
    };
    discountType: Options[];
}

const Details = ({ showTab }: { showTab: boolean }) => {
    const { cashierDetails, discountType, paymentDetails } = usePage()
        .props as unknown as InertiaProps;

    const { data, setData, patch, isDirty, setDefaults } = useForm({
        id: cashierDetails.id,
        total_cost_price: cashierDetails.total_cost_price ?? 0,
        total_price: cashierDetails.total_price ?? 0,
        total_discount: cashierDetails.total_discount ?? 0,
        total_nett_price: cashierDetails.total_nett_price ?? 0,
    });

    const header = [
        { name: 'Description', className: 'sticky-left', align: 'left' },
        { name: 'Cost Price', align: 'center' },
        { name: 'Qty', align: 'center' },
        { name: 'Total Price', align: 'center' },
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
                totalPrice += parseFloat(product.cost_price) * parseFloat(product.quantity);
            }

            if (!isNaN(parseFloat(product.discount))) {
                totalDiscount += parseFloat(product.discount);
            }

            if (!isNaN(parseFloat(product.nett_price))) {
                totalNettPrice += parseFloat(product.nett_price);
            }
        });

        return {
            totalCostPrice: totalCostPrice,
            totalPrice: totalPrice,
            totalDiscount: totalDiscount,
            totalNettPrice: totalNettPrice,
        };
    };

    const computeNettPrice = (id: string, field: string, value: string) => {
        const parsedValue = isNaN(parseFloat(value)) ? 0.0 : parseFloat(value);

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
                updatedItem.total_price === '' &&
                updatedItem.discount === '' &&
                updatedItem.tax_percent === '';

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

            updatedItem.total_price = allBlank ? '' : cost_price * quantity;
            const basePrice = updatedItem.total_price - discount;
            const totalNettPrice = (basePrice * (1 + tax_percent / 100)).toFixed(2);
            updatedItem.nett_price = allBlank ? '' : totalNettPrice;

            let totals = totalValues({ ...prevData, [id]: updatedItem });

            // Return a completely fresh state object
            return {
                ...prevData,
                [id]: updatedItem,
                total_cost_price: totals.totalCostPrice,
                total_price: totals.totalPrice,
                total_discount: totals.totalDiscount,
                total_nett_price: totals.totalNettPrice,
            };
        });
    };

    useEffect(() => {
        const initialFields: Record<string, any> = {};
        cashierDetails.details.map((item, index) => {
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
    }, [cashierDetails.details]);

    const isPaid = () => {
        if (paymentDetails) {
            return paymentDetails.receipt_sequence !== '';
        }

        return false;
    };

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4">
                            <SaveButton type="Details" isDirty={isDirty} isPaid={isPaid()} />
                        </div>
                        <div className="d-flex justify-content-end">
                            {!isPaid() && (
                                <ConfirmButton
                                    requestMethod="PATCH"
                                    url={sendBackToBilling(cashierDetails.billing_id).url}
                                    msg={
                                        'This patient will be sent back to Billing for amount correction(s)!'
                                    }
                                    className="btn-lg me-5"
                                    title="Move Back to Billing"
                                    successTitle="Success!"
                                    successMsg="The record has been updated."
                                    successUrl={cashier().url}
                                >
                                    <IconBuildingBank /> Send to Billing
                                </ConfirmButton>
                            )}
                        </div>
                        <div className="card border shadow-sm">
                            <div className="card-body">
                                <div className="row g-3 mb-5 w-100">
                                    <TableList header={header}>
                                        {cashierDetails.details.map((item, index) => {
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
                                                        <h6
                                                            className="fs-3 fw-normal text-wrap"
                                                            style={{ width: '300px' }}
                                                        >
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
                                                                id={costPriceId}
                                                                value={
                                                                    (
                                                                        data[
                                                                            item.id as keyof typeof data
                                                                        ] as any
                                                                    )?.cost_price ?? ''
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
                                                                className="form-control"
                                                                placeholder="0.00"
                                                                style={{ width: '100px' }}
                                                                readOnly={true}
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
                                                    <td className="sticky-right">
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
                                                    {formatMoney(data.total_cost_price)}
                                                </h6>
                                            </td>
                                            <td className="text-center"></td>
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
                                            <td className="sticky-right text-center">
                                                <h6 className="fs-6 fw-semibold">
                                                    {formatMoney(data.total_nett_price)}
                                                </h6>
                                            </td>
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
