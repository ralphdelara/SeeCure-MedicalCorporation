import { useEffect } from 'react';
import Footer from './footer';
import Header from './header';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-receipt.css';
import { addZeroes, formatReceiptDateTime } from '@/lib/utils';

const PickList = () => {
    const { receiptData, company, itemData } = usePage().props as unknown as {
        receiptData: any;
    };

    console.log(itemData);
    console.log(company);

    useEffect(() => {
        document.body.style.margin = '0';
        //window.print();
    }, []);
    return (
        <>
            <table>
                <tbody>
                    <tr>
                        <td className="text-center" colSpan={2} style={{ fontSize: '13px' }}>
                            SEE CURE MEDICAL CORPORATION
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            {company.address}
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            NON-VAT TIN : 613-797-698-000
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            MIN:
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            S/N:
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '14px', width: '100px' }}
                        >
                            SALES INVOICE
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '1px', width: '100px' }}
                        >
                            SALES INVOICE
                        </td>
                    </tr>
                    <tr>
                        <td>SI #: </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>TRANS. #:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>DATE:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>CASHIER::</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colSpan={2}>-------------------------------------</td>
                    </tr>
                    <tr>
                        <td colSpan={2}>
                            <table className="print-receipt-details">
                                <thead>
                                    <tr>
                                        <td>QTY</td>
                                        <td style={{ width: '155px' }}>UOM DESCRIPTIONS</td>
                                        <td className="text-right">AMOUNT</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colSpan={3}>-------------------------------------</td>
                                    </tr>
                                    {itemData.details.map((item, index) => (
                                        <tr key={'tr-' + index}>
                                            <td style={{ verticalAlign: 'top' }}>
                                                {item.quantity}
                                            </td>
                                            <td style={{ verticalAlign: 'top' }}>
                                                {item.name} @{item.cost_price}
                                            </td>
                                            <td
                                                className="text-right"
                                                style={{ verticalAlign: 'top' }}
                                            >
                                                {item.nett_price}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            ITEM(S) PURCHASED: {parseInt(itemData.total_quantity)}
                        </td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '12px' }}>TOTAL SALES:</td>
                        <td style={{ fontSize: '12px' }} className="text-right">
                            {itemData.total_nett_price}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>-------------------------------------</td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '12px' }}>TOTAL AMOUNT DUE:</td>
                        <td style={{ fontSize: '12px' }} className="text-right">
                            {itemData.tendered ?? ''}
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default PickList;
