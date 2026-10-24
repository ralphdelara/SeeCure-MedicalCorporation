import { useEffect } from 'react';
import Footer from './footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney } from '@/lib/utils';
import BillingHeader from './billing-header';
import PrintHeader from './print-header';

const Default = () => {
    const { printTitle, billing } = usePage().props as unknown as {
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
            total_tax: string;
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
            <div
                style={{
                    width: '557px',
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
                        width: '557px',
                        fontSize: '15px',
                    }}
                    className="fw-semibold mt-2"
                >
                    <tbody>
                        <tr style={{ background: 'var(--bs-success-bg-subtle)' }}>
                            <td className="p-2 text-left">LABORATORY TEST</td>
                            <td className="p-2 text-right" style={{ width: '90px' }}>
                                UNIT PRICE
                            </td>
                            <td className="p-2 text-right" style={{ width: '30px' }}>
                                QTY
                            </td>
                            <td className="p-2 text-right" style={{ width: '90px' }}>
                                TOTAL
                            </td>
                        </tr>
                        {billing.details.map((item, index) => (
                            <tr key={'tr-' + index}>
                                <td width="30%" className="ps-2" align="left" valign="top">
                                    {item.name.toUpperCase()}
                                </td>
                                <td width="12%" className="text-right" valign="top">
                                    {item.cost_price
                                        ? formatMoney(item.cost_price)
                                        : formatMoney('0.00')}
                                </td>
                                <td width="10%" className="text-right text-nowrap" valign="top">
                                    x {item.quantity ?? '1'}
                                </td>
                                <td width="12%" className="pe-2 text-right" valign="top">
                                    {item.total_price
                                        ? formatMoney(item.total_price)
                                        : formatMoney('0.00')}
                                </td>
                            </tr>
                        ))}
                        <tr
                            style={{
                                borderTop: 'dashed 2px #000',
                            }}
                        ></tr>
                        {(parseFloat(billing.total_discount) > 0 ||
                            parseFloat(billing.total_tax) > 0) && (
                            <tr
                                style={{
                                    fontSize: '18px',
                                }}
                            >
                                <td colSpan={3} className="text-right">
                                    SUB TOTAL AMOUNT:
                                </td>
                                <td className="pe-2 text-right">
                                    {formatMoney(billing.total_cost_price)}
                                </td>
                            </tr>
                        )}
                        {parseFloat(billing.total_discount) > 0 && (
                            <tr
                                style={{
                                    fontSize: '18px',
                                }}
                            >
                                <td colSpan={3} className="text-right">
                                    DISCOUNT:
                                </td>
                                <td className="pe-2 text-right">
                                    {formatMoney(billing.total_discount)}
                                </td>
                            </tr>
                        )}
                        {parseFloat(billing.total_tax) > 0 && (
                            <tr
                                style={{
                                    fontSize: '18px',
                                }}
                            >
                                <td colSpan={3} className="text-right">
                                    TAX:
                                </td>
                                <td className="pe-2 text-right">
                                    {formatMoney(billing.total_tax)}
                                </td>
                            </tr>
                        )}
                        <tr
                            style={{
                                fontSize: '18px',
                            }}
                        >
                            <td colSpan={3} className="text-right">
                                TOTAL AMOUNT DUE:
                            </td>
                            <td
                                className="pe-2 text-right"
                                style={{
                                    borderBottom: 'solid 2px #000',
                                }}
                            >
                                {formatMoney(billing.total_nett_price)}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <Footer />
        </>
    );
};

export default Default;
