import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-receipt.css';
import { formatReceiptDateTime } from '@/lib/utils';

const PickList = () => {
    const { pickListDetails, pickListData } = usePage().props as unknown as {
        pickListDetails: any;
        pickListData: any;
    };

    useEffect(() => {
        document.body.style.margin = '0';
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            <table style={{ width: '215px' }}>
                <tbody>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '12px', fontWeight: 'bold' }}
                        >
                            PICK LIST
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>
                            <hr className="text-dark border-dark my-2 border-dashed p-0" />
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Transaction Number
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '12px', fontWeight: 'bold' }}
                        >
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
                        <td colSpan={2}>
                            <hr className="text-dark border-dark my-2 border-dashed p-0" />
                        </td>
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
                        <td style={{ fontSize: '12px', fontWeight: 'bold' }}>TOTAL SALES:</td>
                        <td style={{ fontSize: '12px', fontWeight: 'bold' }} className="text-right">
                            {pickListDetails.total_nett_price}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>
                            <hr className="text-dark border-dark my-2 border-dashed p-0" />
                        </td>
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
