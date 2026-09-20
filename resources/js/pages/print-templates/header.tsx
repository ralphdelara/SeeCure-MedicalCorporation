import appLogo from '@/assets/images/logos/logo.png';
import QRCodeGenerator from '@/components/qr-generator';
import { usePage } from '@inertiajs/react';

const Header = () => {
    const { company, qrUrl } = usePage().props as unknown as {
        company: {
            company_name: string;
            tel_no: string;
            address: string;
        };
        qrUrl: string;
    };

    return (
        <div className="text-center">
            <center>
                <table>
                    <tbody>
                        <tr>
                            <td className="text-center" style={{ position: 'relative' }}>
                                <img
                                    src={appLogo}
                                    style={{
                                        height: '110px',
                                        position: 'absolute',
                                        left: 0,
                                        marginLeft: '-110px',
                                        marginTop: '-8px',
                                    }}
                                />
                                <span
                                    style={{
                                        fontSize: '25px',
                                        color: '#000',
                                        padding: 0,
                                    }}
                                    className="fw-semibold"
                                >
                                    {company.company_name}
                                </span>
                            </td>
                            <td className="text-center" style={{ position: 'relative' }}>
                                {qrUrl && (
                                    <div
                                        style={{
                                            position: 'absolute',
                                            right: '0',
                                            marginRight: '-110px',
                                            marginTop: '-40px',
                                        }}
                                    >
                                        <QRCodeGenerator content={qrUrl} size={50} />
                                    </div>
                                )}
                            </td>
                        </tr>
                        <tr>
                            <td className="text-center">
                                <span
                                    style={{
                                        fontSize: '16px',
                                        color: '#000',
                                        padding: 0,
                                    }}
                                >
                                    {company.address}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td className="text-center">
                                <span
                                    style={{
                                        fontSize: '16px',
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
            </center>
        </div>
    );
};

export default Header;
