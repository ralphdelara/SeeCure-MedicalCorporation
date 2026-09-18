import { usePage } from '@inertiajs/react';
import pathologistSign from '@/assets/images/signature/pathologist-signature.png';

const Footer = () => {
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
    return (
        <center>
            <table style={{ width: '600px' }}>
                <tbody>
                    <tr>
                        <td width="50%">
                            {leftFullName && (
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <hr
                                                    className="border-dark"
                                                    style={{ width: '200px', margin: '0' }}
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td className="text-center">
                                                {leftFullName && (
                                                    <p
                                                        style={{
                                                            fontSize: '15px',
                                                            color: '#000',
                                                            padding: 0,
                                                            margin: 0,
                                                        }}
                                                        className="fw-bolder"
                                                    >
                                                        {leftFullName}
                                                    </p>
                                                )}
                                                {leftLicNo && (
                                                    <p
                                                        style={{
                                                            fontSize: '15px',
                                                            color: '#000',
                                                            padding: 0,
                                                            margin: 0,
                                                        }}
                                                        className="fw-bolder"
                                                    >
                                                        Lic. No. {leftLicNo}
                                                    </p>
                                                )}
                                                {leftPtrNo && (
                                                    <p
                                                        style={{
                                                            fontSize: '15px',
                                                            color: '#000',
                                                            padding: 0,
                                                            margin: 0,
                                                        }}
                                                        className="fw-bolder"
                                                    >
                                                        PTR No. {leftPtrNo}
                                                    </p>
                                                )}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            )}
                        </td>
                        <td>
                            {rightFullName && (
                                <table align="right">
                                    <tbody>
                                        <tr>
                                            <td>
                                                
                                                <hr
                                                    className="border-dark"
                                                    style={{ margin: '0' }}
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td className="text-center">
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
                                                        {rightFullName}
                                                    </p>
                                                )}
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
                                                        Lic. No. {rightLicNo}
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
                                                        PTR No. {rightPtrNo}
                                                    </p>
                                                )}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            )}
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    );
};

export default Footer;
