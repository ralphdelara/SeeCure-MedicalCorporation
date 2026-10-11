import appLogo from '@/assets/images/logos/logo.png';
import QRCodeGenerator from '@/components/qr-generator';
import { usePage } from '@inertiajs/react';

const PrintHeader = () => {
    const { company, qrUrl } = usePage().props as unknown as {
        company: {
            company_name: string;
            tel_no: string;
            address: string;
            clinic_hours: string;
        };
        qrUrl: string;
    };

    return (
        <table style={{ width: '100%' }}>
            <tbody>
                <tr>
                    <td style={{ width: '110px' }}>
                        <img
                            src={appLogo}
                            style={{
                                height: '110px',
                            }}
                        />
                    </td>
                    <td align="left" style={{ lineHeight: '1' }}>
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
                        <br />
                        <span
                            style={{
                                fontSize: '13px',
                                color: '#000',
                                padding: 0,
                            }}
                        >
                            Clinic Hours:{' '}
                        </span>
                        <span
                            style={{
                                fontSize: '13px',
                                color: '#000',
                                padding: 0,
                            }}
                        >
                            {company.clinic_hours}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    );
};

export default PrintHeader;
