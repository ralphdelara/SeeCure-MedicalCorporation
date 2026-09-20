import { useEffect } from 'react';
import Footer from './footer';
import Header from './header';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-receipt.css';
import { addZeroes, formatReceiptDateTime } from '@/lib/utils';

const PickList = () => {
    const { pickListDetails, pickListData } = usePage().props as unknown as {
        pickListDetails: any;
        pickListData: any;
    };

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
                            PICK LIST
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>-------------------------------------</td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Transaction Number
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2} style={{ fontSize: '12px' }}>
                            {pickListData.transaction_no}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-left">CASHIER:</td>
                        <td className="text-right">PICKLIST</td>
                    </tr>
                    <tr>
                        <td className="text-left">DATETIME TRANS.:</td>
                        <td className="text-right">
                            {formatReceiptDateTime(pickListDetails.updated_at)}
                        </td>
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
                                    {pickListDetails.details.map((item, index) => (
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
                            ITEM(S) PURCHASED: {parseInt(pickListDetails.total_quantity)}
                        </td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '12px' }}>TOTAL SALES:</td>
                        <td style={{ fontSize: '12px' }} className="text-right">
                            {pickListDetails.total_nett_price}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>-------------------------------------</td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            This is not for official receipt.
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default PickList;
