import { Fragment, useEffect } from 'react';
import Footer from './footer';
import appLogo from '@/assets/images/logos/logo.png';
import QRCodeGenerator from '@/components/qr-generator';
import { usePage } from '@inertiajs/react';
import '@/assets/css/print.css';
import RxIcon from '@/assets/images/prescription/rx-icon.png';

const Default = () => {
    const { prescription } = usePage().props as unknown as {
        prescription: {
            inventory_name: string;
            quantity: string;
            dosage: string;
        }[];
    };
    const { leftFullName, leftPtrNo, leftLicNo, rightFullName, rightPtrNo, rightLicNo, controlNo } =
        usePage().props as unknown as {
            leftFullName: string;
            leftPtrNo: string;
            leftLicNo: string;
            rightFullName: string;
            rightPtrNo: string;
            rightLicNo: string;
            controlNo: string;
        };
    const { company, qrUrl } = usePage().props as unknown as {
        company: {
            company_name: string;
            tel_no: string;
            address: string;
        };
        qrUrl: string;
    };

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 500);
    }, []);
    return (
        <div
            style={{
                position: 'relative',
                width: '450px',
                height: '500px',
            }}
        >
            <table style={{ width: '450px' }}>
                <tbody>
                    <tr>
                        <td>
                            <img
                                src={appLogo}
                                style={{
                                    height: '80px',
                                }}
                            />
                        </td>
                        <td>
                            <span
                                style={{
                                    fontSize: '22px',
                                    color: '#000',
                                    padding: 0,
                                }}
                                className="fw-semibold"
                            >
                                {company.company_name}
                            </span>
                            <br />
                            <span
                                style={{
                                    fontSize: '13px',
                                    color: '#000',
                                    padding: 0,
                                }}
                            >
                                {company.address}
                            </span>
                            <br />
                            <span
                                style={{
                                    fontSize: '13px',
                                    color: '#000',
                                    padding: 0,
                                }}
                            >
                                Tel. No. {company.tel_no}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table
                style={{
                    width: '450px',
                    fontSize: '15px',
                }}
                className="mt-2"
            >
                <tbody>
                    <tr>
                        <td rowSpan={prescription.length} style={{ verticalAlign: 'top' }}>
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
                                                    {item.inventory_name}
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
                                                    <i>{item.dosage}</i>
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
            <table style={{ width: '450px', position: 'absolute', bottom: '0' }}>
                <tbody>
                    <tr>
                        <td width="40%"></td>
                        <td style={{ padding: '20px' }}>
                            {rightFullName && (
                                <>
                                    <div className="text-center">
                                        {rightFullName && (
                                            <p
                                                style={{
                                                    fontSize: '15px',
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
                                        <p
                                            style={{
                                                fontSize: '15px',
                                                color: '#000',
                                                padding: 0,
                                                margin: 0,
                                            }}
                                            className="fw-bolder"
                                        >
                                            PHYSICIAN
                                        </p>
                                        {rightLicNo && (
                                            <p
                                                style={{
                                                    fontSize: '15px',
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
                                                    fontSize: '15px',
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
