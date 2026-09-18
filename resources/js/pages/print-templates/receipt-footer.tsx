import { usePage } from '@inertiajs/react';

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
                <tr>
                    <td width="50%">
                        Not valid without Dry Seal Control No: {controlNo}
                        {leftFullName && (
                            <table>
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
                                                className="fw-semibold"
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
                                                className="fw-semibold"
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
                                                className="fw-semibold"
                                            >
                                                PTR No. {leftPtrNo}
                                            </p>
                                        )}
                                    </td>
                                </tr>
                            </table>
                        )}
                    </td>
                    <td>
                        {rightFullName && (
                            <table align="right">
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
                                        {rightFullName && (
                                            <p
                                                style={{
                                                    fontSize: '15px',
                                                    color: '#000',
                                                    padding: 0,
                                                    margin: 0,
                                                }}
                                                className="fw-semibold"
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
                                                className="fw-semibold"
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
                                                className="fw-semibold"
                                            >
                                                PTR No. {rightPtrNo}
                                            </p>
                                        )}
                                    </td>
                                </tr>
                            </table>
                        )}
                    </td>
                </tr>
            </table>
        </center>
    );
};

export default Footer;
