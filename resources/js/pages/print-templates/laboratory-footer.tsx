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
            <table style={{ width: '700px' }}>
                <tbody>
                    <tr>
                        <td width="50%">
                            {leftFullName && (
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="50%">
                                                {leftFullName && (
                                                    <p
                                                        style={{
                                                            fontSize: '15px',
                                                            color: '#000',
                                                            padding: 0,
                                                            margin: 0,
                                                        }}
                                                        className="fw-bolder text-center"
                                                    >
                                                        {leftFullName}
                                                    </p>
                                                )}
                                                <hr
                                                    className="border-dark"
                                                    style={{ margin: '0' }}
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td className="text-center">
                                                <p
                                                    style={{
                                                        fontSize: '15px',
                                                        color: '#000',
                                                        padding: 0,
                                                        margin: 0,
                                                    }}
                                                    className="fw-bolder"
                                                >
                                                    MEDICAL TECHNOLOGIST
                                                </p>
                                                <p
                                                    style={{
                                                        fontSize: '15px',
                                                        color: '#000',
                                                        padding: 0,
                                                        margin: 0,
                                                    }}
                                                    className="fw-bolder"
                                                >
                                                    {leftLicNo ? (
                                                        <>PRC LICENSE NO. {leftLicNo}</>
                                                    ) : (
                                                        <>&nbsp;</>
                                                    )}
                                                </p>
                                                <p
                                                    style={{
                                                        fontSize: '15px',
                                                        color: '#000',
                                                        padding: 0,
                                                        margin: 0,
                                                    }}
                                                    className="fw-bolder"
                                                >
                                                    {leftPtrNo && <>PTR NO. {leftPtrNo}</>}
                                                </p>
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
                                            <td align="center" style={{ position: 'relative' }}>
                                                <img
                                                    src={pathologistSign}
                                                    style={{
                                                        height: '70px',
                                                        position: 'absolute',
                                                        top: '0',
                                                        marginTop: '-50px',
                                                        marginLeft: '50px',
                                                    }}
                                                />
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
                                                <hr
                                                    className="border-dark"
                                                    style={{ margin: '0' }}
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td className="text-center">
                                                {rightLicNo && (
                                                    <>
                                                        <p
                                                            style={{
                                                                fontSize: '15px',
                                                                color: '#000',
                                                                padding: 0,
                                                                margin: 0,
                                                            }}
                                                            className="fw-bolder"
                                                        >
                                                            PATHOLOGIST
                                                        </p>
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
                                                    </>
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
