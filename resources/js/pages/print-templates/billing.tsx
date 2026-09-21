import { useEffect } from 'react';
import Footer from './footer';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import { formatMoney } from '@/lib/utils';
import Header from './header-documents';

const Default = () => {
    const { printTitle, billing } = usePage().props as unknown as {
        printTitle: string;
        billing: {
            name: string;
            cost_price: string;
            quantity: string;
        }[];
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            <Header />
            <div className="text-dark mt-3 mb-12 text-center">
                <center>
                    <table
                        style={{
                            width: '600px',
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
                                <td className="text-right">Discount</td>
                                <td className="text-right">Tax</td>
                                <td className="text-right">Nett</td>
                            </tr>
                            {billing.details.map((item, index) => (
                                <tr key={'tr-' + index}>
                                    <td width="50%" className="mt-2" valign="top">
                                        {item.name}
                                    </td>
                                    <td width="10%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.price ? formatMoney(item.price) : formatMoney('0.00')}
                                    </td>
                                    <td
                                        width="10%"
                                        className="mt-2 ps-2 text-right text-nowrap"
                                        valign="top"
                                    >
                                        x {item.quantity ?? '1'}
                                    </td>
                                    <td width="10%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.discount
                                            ? formatMoney(item.discount)
                                            : formatMoney('0.00')}
                                    </td>
                                    <td
                                        width="10%"
                                        className="mt-2 ps-2 text-right text-nowrap"
                                        valign="top"
                                    >
                                        {item.tax_percent ? item.tax_percent : '0.00 %'}
                                    </td>
                                    <td width="10%" className="mt-2 ps-2 text-right" valign="top">
                                        {item.nett_price
                                            ? formatMoney(item.nett_price)
                                            : formatMoney('0.00')}
                                    </td>
                                </tr>
                            ))}
                            <tr
                                style={{
                                    fontSize: '18px',
                                }}
                            >
                                <td>Total</td>
                                <td className="text-right">{formatMoney(billing.total_price)}</td>
                                <td></td>
                                <td className="text-right">
                                    {formatMoney(billing.total_discount)}
                                </td>
                                <td></td>
                                <td className="text-right">
                                    {formatMoney(billing.total_nett_price)}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
            <Footer />
        </>
    );
};

export default Default;
