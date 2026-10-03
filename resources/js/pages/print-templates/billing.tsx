import { useEffect } from 'react';
import Footer from './footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { addZeroes, formatMoney } from '@/lib/utils';
import Header from './header-documents';
import BillingHeader from './billing-header';
import PrintHeader from './print-header';

const Default = () => {
    const { printTitle, billing, printedBy } = usePage().props as unknown as {
        printTitle: string;
        billing: {
            details: {
                name: string;
                cost_price: string;
                quantity: string;
                total_price: string;
                discount: string;
                tax_percent: string;
                nett_price: string;
            }[];
            total_cost_price: string;
            total_quantity: string;
            total_price: string;
            total_discount: string;
            total_nett_price: string;
            transaction_header: string;
            transaction_no: string;
        };
        printedBy: string;
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            <center>
                <div
                    className="text-dark mt-3 mb-12 text-center"
                    style={{
                        width: '600px',
                    }}
                >
                    <PrintHeader />
                    <table
                        style={{
                            width: '100%',
                        }}
                    >
                        <tbody>
                            <tr>
                                <td
                                    className="text-center"
                                    style={{ position: 'relative' }}
                                    colSpan={3}
                                >
                                    <span
                                        style={{
                                            fontSize: '20px',
                                            color: '#000',
                                            padding: 0,
                                            fontWeight: 'bold',
                                        }}
                                        className="fw-bolder"
                                    >
                                        {printTitle}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <BillingHeader />
                    <table
                        style={{
                            width: '600px',
                            fontSize: '15px',
                        }}
                        className="fw-semibold mt-4"
                    >
                        <tbody>
                            <tr>
                                <td></td>
                                <td className="text-right">Price</td>
                                <td className="text-right">Qty</td>
                                <td className="text-right">Total</td>
                                <td className="text-right">Discount</td>
                                <td className="text-right">Tax</td>
                                <td className="text-right">Nett</td>
                            </tr>
                            {billing.details.map((item, index) => (
                                <tr key={'tr-' + index}>
                                    <td width="30%" className="mt-2" align="left" valign="top">
                                        {item.name}
                                    </td>
                                    <td width="12%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.cost_price
                                            ? formatMoney(item.cost_price)
                                            : formatMoney('0.00')}
                                    </td>
                                    <td
                                        width="10%"
                                        className="mt-2 ps-2 text-right text-nowrap"
                                        valign="top"
                                    >
                                        x {item.quantity ?? '1'}
                                    </td>
                                    <td width="12%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.total_price
                                            ? formatMoney(item.total_price)
                                            : formatMoney('0.00')}
                                    </td>
                                    <td width="12%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.discount
                                            ? formatMoney(item.discount)
                                            : formatMoney('0.00')}
                                    </td>
                                    <td
                                        width="12%"
                                        className="mt-2 ps-2 text-right text-nowrap"
                                        valign="top"
                                    >
                                        {item.tax_percent ? item.tax_percent : '0.00 %'}
                                    </td>
                                    <td width="12%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.nett_price
                                            ? formatMoney(item.nett_price)
                                            : formatMoney('0.00')}
                                    </td>
                                </tr>
                            ))}
                            <tr
                                style={{
                                    fontSize: '18px',
                                    borderTop: 'solid 1px #000'
                                }}
                            >
                                <td align="left">Total</td>
                                <td className="ps-2 text-right">
                                    {formatMoney(billing.total_cost_price)}
                                </td>
                                <td className="text-right">{billing.total_quantity}</td>
                                <td className="ps-2 text-right">
                                    {formatMoney(billing.total_price)}
                                </td>
                                <td className="ps-2 text-right">
                                    {formatMoney(billing.total_discount)}
                                </td>
                                <td></td>
                                <td className="ps-2 text-right">
                                    {formatMoney(billing.total_nett_price)}
                                </td>
                            </tr>
                            <tr>
                                <td colSpan={3}>
                                    <div style={{ marginTop: '100px' }}>
                                        Control No:{' '}
                                        <span className="text-danger">
                                            {billing.transaction_header}-
                                            {addZeroes(billing.transaction_no, 8)}
                                        </span>
                                    </div>
                                </td>
                                <td></td>
                                <td colSpan={3}>
                                    <div style={{ marginTop: '100px', textAlign: 'center' }}>
                                        {printedBy.toUpperCase()}
                                        <hr
                                            className="border-dark"
                                            style={{
                                                margin: '0',
                                            }}
                                        />
                                        PRINTED BY
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </center>
            <Footer />
        </>
    );
};

export default Default;
