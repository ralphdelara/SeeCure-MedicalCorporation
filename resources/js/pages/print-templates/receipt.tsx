import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-receipt.css';
import { addZeroes, formatReceiptDateTime } from '@/lib/utils';

const PickList = () => {
    const { receiptData, company, itemData, transactionNo, companyDetails } = usePage()
        .props as unknown as {
        receiptData: any;
    };

    useEffect(() => {
        document.body.style.margin = '0';
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <>
            <table style={{ width: '300px' }}>
                <tbody>
                    <tr>
                        <td className="text-center" colSpan={2} style={{ fontSize: '15px' }}>
                            {company.company_name.toUpperCase()}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2} style={{ fontSize: '11px' }}>
                            <center>
                                <div style={{ width: '200px', textAlign: 'center' }}>
                                    {company.address}
                                </div>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            NON-VAT TIN : {companyDetails.nonVatTin}
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            MIN : {companyDetails.min}
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            S/N : {companyDetails.sn}
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
                        <td className="text-right">{addZeroes(receiptData.transaction_no, 14)}</td>
                    </tr>
                    <tr>
                        <td>TRANS. #:</td>
                        <td className="text-right">{transactionNo}</td>
                    </tr>
                    <tr>
                        <td>DATE:</td>
                        <td className="text-right">{receiptData.created_date}</td>
                    </tr>
                    <tr>
                        <td>CASHIER:</td>
                        <td className="text-right">{receiptData.created_by.full_name_receipt}</td>
                    </tr>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
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
                                        <td colSpan={3}>
                                            -------------------------------------------------
                                        </td>
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
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '13px' }}>TOTAL AMOUNT DUE:</td>
                        <td style={{ fontSize: '13px' }} className="text-right">
                            {itemData.total_nett_price}
                        </td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '10px' }}>Tendered:</td>
                        <td style={{ fontSize: '10px' }} className="text-right"></td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '10px' }}>
                            {receiptData.method.name.toUpperCase()}: <br />
                            {receiptData.reference_number && (
                                <small>#{receiptData.reference_number}</small>
                            )}
                        </td>
                        <td style={{ fontSize: '10px' }} className="text-right">
                            {receiptData.amount_received}
                        </td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '13px' }}>CHANGE:</td>
                        <td style={{ fontSize: '13px' }} className="text-right">
                            {receiptData.amount_change}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            {formatReceiptDateTime(receiptData.created_at)}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td>CUST NAME:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>CUST ADDR:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>CUST TIN:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>BUS STYLE:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>SC/PWD/NAAC/SP/MOV ID:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>SIGNATURE:</td>
                        <td>__________________________</td>
                    </tr>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            THIS SERVES AS A SALES INVOICE
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            {company.company_name.toUpperCase()}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            {company.address}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            NON-VAT REG TIN : {companyDetails.nonVatTin}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            ACCRE. NO.
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Date Issued:
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            PTU NO. :
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Date Issued:
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default PickList;
