import { Fragment, useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import RxIcon from '@/assets/images/prescription/rx-icon.png';
import PrescriptionHeader from './prescription-header';
import PrintHeader from './print-header';

const Default = () => {
    const { prescription } = usePage().props as unknown as {
        prescription: {
            inventory_name: string;
            quantity: string;
            sig: string;
        }[];
    };
    const { prescriptionRemarks, rightFullName, rightPtrNo, rightLicNo } = usePage()
        .props as unknown as {
        prescriptionRemarks: string;
        leftFullName: string;
        leftPtrNo: string;
        leftLicNo: string;
        rightFullName: string;
        rightPtrNo: string;
        rightLicNo: string;
        controlNo: string;
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 1000);
    }, []);
    return (
        <div
            style={{
                position: 'relative',
                width: '450px',
                height: '500px',
            }}
        >
            <PrintHeader />
            <PrescriptionHeader />
            <table
                style={{
                    width: '450px',
                    fontSize: '15px',
                }}
                className="mt-2"
            >
                <tbody>
                    <tr>
                        <td
                            rowSpan={prescription.length}
                            style={{ width: '30px', verticalAlign: 'top' }}
                        >
                            <img
                                src={RxIcon}
                                style={{
                                    height: '30px',
                                }}
                            />
                        </td>
                        <td style={{ padding: '30px' }}>
                            <table>
                                <tbody>
                                    {prescription.map((item, index) => (
                                        <Fragment key={'tr-' + index}>
                                            <tr>
                                                <td
                                                    width="95%"
                                                    className="mt-2"
                                                    valign="top"
                                                    style={{ fontSize: '15px', color: '#000' }}
                                                >
                                                    <b>{item.inventory_name}</b>
                                                </td>
                                                <td
                                                    width="5%"
                                                    className="mt-2 ps-2 text-right text-nowrap"
                                                    valign="top"
                                                    style={{ fontSize: '15px', color: '#000' }}
                                                >
                                                    x {item.quantity}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style={{ fontSize: '15px', color: '#000' }}
                                                    colSpan={2}
                                                >
                                                    <i>
                                                        Sig:{' '}
                                                        {item.sig
                                                            .replace('Sig:', '')
                                                            .replace('sig:', '')
                                                            .replace('SIG:', '')}
                                                    </i>
                                                </td>
                                            </tr>
                                        </Fragment>
                                    ))}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style={{ width: '450px' }}>
                <tbody>
                    <tr>
                        <td colSpan={2}>
                            <div className="d-flex">
                                <p
                                    style={{
                                        fontSize: '15px',
                                        color: '#000',
                                        padding: 0,
                                        margin: 0,
                                    }}
                                    className="fw-bolder"
                                >
                                    Remarks:
                                </p>
                                <div style={{ marginLeft: '10px', width: '70%' }}>
                                    {prescriptionRemarks ?? <>&nbsp;</>}
                                    <hr
                                        className="border-dark"
                                        style={{ margin: '0', width: '100%' }}
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style={{ width: '450px', marginTop: '30px' }}>
                <tbody>
                    <tr>
                        <td width="40%"></td>
                        <td style={{ padding: '20px' }}>
                            {rightFullName && (
                                <>
                                    <div className="text-center text-nowrap">
                                        {rightFullName && (
                                            <p
                                                style={{
                                                    fontSize: '14px',
                                                    color: '#000',
                                                    padding: 0,
                                                    margin: 0,
                                                }}
                                                className="fw-bolder"
                                            >
                                                {rightFullName.toUpperCase()}
                                            </p>
                                        )}
                                        <hr
                                            className="border-dark"
                                            style={{ margin: '0', width: '100%' }}
                                        />
                                        {rightLicNo && (
                                            <p
                                                style={{
                                                    fontSize: '14px',
                                                    color: '#000',
                                                    padding: 0,
                                                    margin: 0,
                                                }}
                                                className="fw-bolder"
                                            >
                                                PRC LICENSE NO. {rightLicNo}
                                            </p>
                                        )}
                                        {rightPtrNo && (
                                            <p
                                                style={{
                                                    fontSize: '14px',
                                                    color: '#000',
                                                    padding: 0,
                                                    margin: 0,
                                                }}
                                                className="fw-bolder"
                                            >
                                                PTR NO. {rightPtrNo}
                                            </p>
                                        )}
                                    </div>
                                </>
                            )}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    );
};

export default Default;
