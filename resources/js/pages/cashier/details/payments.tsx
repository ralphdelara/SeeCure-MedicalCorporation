import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { useEffect, useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formatMoney, formSubmitResponse, printDocument } from '@/lib/utils';
import React from 'react';
import SaveButton from './save-button';
import { updateDetails } from '@/actions/App/Http/Controllers/CashierController';
import TableList from '@/components/table';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { IconDeviceFloppy, IconPrinter } from '@tabler/icons-react';
import { addOrUpdatePayment } from '@/routes/cashier/details';
import { toast } from 'react-hot-toast';

interface PaymentDetailsProps {
    id: string;
    cashier_id: string;
    patient_id: string;
    visit_id: string;
    payment_id: string;
    payment_method_id: string | number;
    reference_number: string | number;
    total_amount: string;
    amount_received: string;
    amount_change: string;
    receipt_sequence_header: string;
    receipt_sequence: string;
}

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
        visit: {
            id: string;
            consultation: {
                id: string;
            };
        };
        patient: {
            id: string;
        };
        total_cost_price: string;
        total_price: string;
        total_discount: string;
        total_nett_price: string;
        total_tax: string;
    };
    discountType: Options[];
    paymentDetails: PaymentDetailsProps;
    paymentMethodOptions: Options[];
}

const Payments = ({ showTab }: { showTab: boolean }) => {
    const { cashierDetails, paymentDetails, paymentMethodOptions } = usePage()
        .props as unknown as InertiaProps;

    const { data, setData, post, isDirty, setDefaults } = useForm<PaymentDetailsProps>({
        id: '',
        cashier_id: cashierDetails.id,
        patient_id: cashierDetails.patient.id,
        visit_id: cashierDetails.visit.id,
        payment_id: paymentDetails?.id ?? '',
        payment_method_id: paymentDetails?.payment_method_id ?? 1, // Cash
        reference_number: paymentDetails?.reference_number ?? '',
        total_amount: cashierDetails.total_nett_price ?? 0,
        amount_received: paymentDetails?.amount_received ?? 0,
        amount_change: paymentDetails?.amount_change ?? 0,
        receipt_sequence: paymentDetails?.receipt_sequence ?? '',
        receipt_sequence_header: paymentDetails?.receipt_sequence_header ?? '',
    });

    const submitDetails = async (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdatePayment().url, {
            ...formSubmitResponse('Payment'),
            ...{
                onSuccess: (page) => {
                    toast.success('Payment has been saved!');
                    const pageProps = page.props as unknown as {
                        paymentDetails: PaymentDetailsProps;
                    };
                    const paymentDetailsResponse = pageProps.paymentDetails as PaymentDetailsProps;

                    setData('id', paymentDetailsResponse.id);
                    setData('cashier_id', paymentDetailsResponse.cashier_id as keyof typeof data);
                    setData('patient_id', paymentDetailsResponse.patient_id);
                    setData('visit_id', paymentDetailsResponse.visit_id);
                    setData('payment_id', paymentDetailsResponse.id);
                    setData('payment_method_id', paymentDetailsResponse.payment_method_id);
                    setData('reference_number', paymentDetailsResponse.reference_number);
                    setData('total_amount', paymentDetailsResponse.total_amount);
                    setData('amount_received', paymentDetailsResponse.amount_received);
                    setData('amount_change', paymentDetailsResponse.amount_change);
                },
            },
        });
    };

    const computeChange = (amountReceived: string) => {
        const received = parseFloat(amountReceived);
        const change = received - Number(data.total_amount);

        setData('amount_change', (!isNaN(change) ? change.toFixed(2) : 0.0).toString());
        setData('amount_received', amountReceived);
    };

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
                            <SaveButton
                                type="Payments"
                                isDirty={isDirty}
                                hideSaveButton={true}
                                isPaid={isPaid()}
                            />
                        </div>
                        <div className="row g-3 mb-5 w-100">
                            <div className="col-md-8">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <div className="d-flex justify-content-between">
                                            {paymentDetails?.receipt_sequence && (
                                                <>
                                                    <Button
                                                        size="lg"
                                                        type="button"
                                                        onClick={() => printDocument('')}
                                                    >
                                                        <IconPrinter /> Print Receipt
                                                    </Button>
                                                    <h5 className="fs-6 fw-bolder mt-3">
                                                        #{' '}
                                                        {paymentDetails?.receipt_sequence_header ??
                                                            '••••••••'}
                                                        -
                                                        {paymentDetails?.receipt_sequence ??
                                                            '••••••••'}
                                                    </h5>
                                                </>
                                            )}
                                        </div>
                                        <div className="table-responsive">
                                            <table className="table">
                                                <thead>
                                                    <tr>
                                                        <th style={{ width: '300px' }}>
                                                            Description
                                                        </th>
                                                        <th style={{ textAlign: 'right' }}>
                                                            Price
                                                        </th>
                                                        <th style={{ textAlign: 'right' }}>Qty</th>
                                                        <th style={{ textAlign: 'right' }}>
                                                            Total
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {cashierDetails.details.map((item, index) => (
                                                        <tr key={'payment-details-' + index}>
                                                            <td style={{ width: '300px' }}>
                                                                {item.name}
                                                                <br />
                                                                <small>{item.type.name}</small>
                                                            </td>
                                                            <td style={{ textAlign: 'right' }}>
                                                                {formatMoney(item.cost_price ?? 0)}
                                                            </td>
                                                            <td style={{ textAlign: 'right' }}>
                                                                {item.quantity ?? 0}
                                                            </td>
                                                            <td style={{ textAlign: 'right' }}>
                                                                {formatMoney(item.total_price ?? 0)}
                                                            </td>
                                                        </tr>
                                                    ))}
                                                    <tr>
                                                        <td
                                                            colSpan={3}
                                                            style={{ textAlign: 'right' }}
                                                        >
                                                            Total Price
                                                        </td>
                                                        <td style={{ textAlign: 'right' }}>
                                                            {formatMoney(
                                                                cashierDetails.total_price,
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            colSpan={3}
                                                            style={{ textAlign: 'right' }}
                                                        >
                                                            Total Discount
                                                        </td>
                                                        <td style={{ textAlign: 'right' }}>
                                                            {formatMoney(
                                                                cashierDetails.total_discount,
                                                            )}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            colSpan={3}
                                                            style={{ textAlign: 'right' }}
                                                        >
                                                            Total Tax
                                                        </td>
                                                        <td style={{ textAlign: 'right' }}>
                                                            {formatMoney(cashierDetails.total_tax)}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        style={{
                                                            fontSize: '20px',
                                                            fontWeight: 'bolder',
                                                        }}
                                                    >
                                                        <td
                                                            colSpan={3}
                                                            style={{ textAlign: 'right' }}
                                                        >
                                                            Pay
                                                        </td>
                                                        <td style={{ textAlign: 'right' }}>
                                                            {formatMoney(
                                                                cashierDetails.total_nett_price,
                                                            )}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-4">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <div className="form-group text-center">
                                            <h5 className="fs-7">Total Amount</h5>
                                            <h5 className="fs-11 fw-bolder">
                                                {formatMoney(cashierDetails.total_nett_price)}
                                            </h5>
                                        </div>
                                        <div className="form-group text-center">
                                            <Select
                                                value={data.payment_method_id}
                                                onChange={(e) =>
                                                    setData(
                                                        'payment_method_id',
                                                        parseInt(e.target.value),
                                                    )
                                                }
                                                className="fs-7 fw-bolder text-center"
                                                options={paymentMethodOptions}
                                                type="Payment Method"
                                            />
                                        </div>
                                        {data.payment_method_id === 1 && (
                                            <>
                                                <div className="form-group text-center">
                                                    <Label
                                                        htmlFor="amount_received"
                                                        className="fs-7"
                                                    >
                                                        Received
                                                    </Label>
                                                    <div className="input-group d-flex flex-nowrap">
                                                        <span className="input-group-text fs-7 fw-bolder">
                                                            ₱
                                                        </span>
                                                        <Input
                                                            name="amount_received"
                                                            type="text"
                                                            value={data.amount_received}
                                                            onChange={(e) =>
                                                                computeChange(e.target.value)
                                                            }
                                                            className="form-control fs-10 fw-bolder p-1 text-center"
                                                            placeholder="0.00"
                                                            step="0.01"
                                                        />
                                                    </div>
                                                </div>
                                                <div className="form-group text-center">
                                                    <h5 className="fs-7">Change</h5>
                                                    <div className="input-group d-flex flex-nowrap">
                                                        <span className="input-group-text fs-7 fw-bolder">
                                                            ₱
                                                        </span>

                                                        <Input
                                                            name="amount_change"
                                                            value={data.amount_change}
                                                            className="form-control fs-10 fw-bolder p-1 text-center"
                                                            placeholder="0.00"
                                                            readOnly={true}
                                                        />
                                                    </div>
                                                </div>
                                            </>
                                        )}
                                        {data.payment_method_id !== 1 && (
                                            <div className="form-group text-center">
                                                <Label htmlFor="reference_number" className="fs-7">
                                                    Reference Number
                                                </Label>
                                                <div className="input-group d-flex flex-nowrap">
                                                    <span className="input-group-text fs-7 fw-bolder">
                                                        #
                                                    </span>
                                                    <Input
                                                        name="reference_number"
                                                        type="text"
                                                        value={data.reference_number}
                                                        onChange={(e) =>
                                                            setData(
                                                                'reference_number',
                                                                e.target.value,
                                                            )
                                                        }
                                                        className="form-control form-control-lg fs-10 fw-bolder text-center"
                                                        placeholder="••••••••"
                                                        maxLength={50}
                                                    />
                                                </div>
                                            </div>
                                        )}
                                        <div className="form-group text-center">
                                            <Button size="lg" className="ms-3">
                                                <i>
                                                    <IconDeviceFloppy className="me-1" />
                                                </i>
                                                Save Payment
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

export default Payments;
