import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print-receipt.css';
import { addZeroes, formatReceiptDateTime } from '@/lib/utils';

const PickList = () => {
    const {
        receiptData,
        itemData,
        transactionNo,
        companyProfile,
    } = usePage().props as unknown as {
        receiptData: any;
        itemData: {
            details: {
                name: string;
                cost_price: string;
                quantity: string;
                price: string;
                nett_price: string;
                discount: string;
            }[];
            total_quantity: string;
            total_nett_price: string;
        };
        transactionNo: string;
        companyProfile: {
            company_name: string;
            address: string;
            non_vat_tin: string;
            sn: string;
            min: string;
            accreditation_no: string;
            accreditation_date_issued: string;
            ptu_no: string;
            ptu_date_issued: string;
        };
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
                            {companyProfile.company_name.toUpperCase()}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2} style={{ fontSize: '11px' }}>
                            <center>
                                <div style={{ width: '200px', textAlign: 'center' }}>
                                    {companyProfile.address}
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
                            NON-VAT TIN : {companyProfile.non_vat_tin}
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            MIN : {companyProfile.min}
                        </td>
                    </tr>
                    <tr>
                        <td
                            className="text-center"
                            colSpan={2}
                            style={{ fontSize: '11px', width: '100px' }}
                        >
                            S/N : {companyProfile.sn}
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
                        <td className="text-right">{transactionNo ?? '-'}</td>
                    </tr>
                    <tr>
                        <td>DATE:</td>
                        <td className="text-right">{receiptData.created_date}</td>
                    </tr>
                    <tr>
                        <td>CASHIER:</td>
                        <td className="text-right">
                            {receiptData.created_by.full_name_receipt.toUpperCase()}
                        </td>
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
                                                {item.name} @{item.cost_price ?? '0.00'}
                                            </td>
                                            <td
                                                className="text-right"
                                                style={{ verticalAlign: 'top' }}
                                            >
                                                {parseFloat(item.nett_price ?? '0').toLocaleString(
                                                    'en-US',
                                                    {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2,
                                                    },
                                                )}
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
                            {parseFloat(itemData.total_nett_price).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td style={{ fontSize: '13px' }}>TOTAL AMOUNT DUE:</td>
                        <td style={{ fontSize: '13px' }} className="text-right">
                            {parseFloat(itemData.total_nett_price).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })}
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
                            {parseFloat(receiptData.amount_received).toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })}
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
                </tbody>
            </table>
            <table style={{ width: '300px' }}>
                <tbody>
                    <tr>
                        <td colSpan={2}>--------------------------------------------------</td>
                    </tr>
                    <tr>
                        <td>CUST NAME:</td>
                        <td className="text-right">
                            {receiptData.customer_name?.toUpperCase() ?? '-'}
                        </td>
                    </tr>
                    <tr>
                        <td>CUST ADDR:</td>
                        <td className="text-right">
                            {receiptData.customer_address?.toUpperCase() ?? '-'}
                        </td>
                    </tr>
                    <tr>
                        <td>CUST TIN:</td>
                        <td className="text-right">-</td>
                    </tr>
                    <tr>
                        <td>BUS STYLE:</td>
                        <td className="text-right">-</td>
                    </tr>
                    <tr>
                        <td>SC/PWD/NAAC/SP/MOV ID:</td>
                        <td className="text-right">{receiptData.id_no ?? '-'}</td>
                    </tr>
                    <tr>
                        <td>SIGNATURE:</td>
                        <td className="text-right">__________________________</td>
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
                            {companyProfile.company_name.toUpperCase()}
                        </td>
                    </tr>
                    <tr>
                        <td colSpan={2} className="text-center">
                            {companyProfile.address}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            NON-VAT REG TIN : {companyProfile.non_vat_tin ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            ACCRE. NO. {companyProfile.accreditation_no ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Date Issued: {companyProfile.accreditation_date_issued ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            PTU NO. : {companyProfile.ptu_no ?? 'N/A'}
                        </td>
                    </tr>
                    <tr>
                        <td className="text-center" colSpan={2}>
                            Date Issued: {companyProfile.ptu_date_issued ?? 'N/A'}
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default PickList;
