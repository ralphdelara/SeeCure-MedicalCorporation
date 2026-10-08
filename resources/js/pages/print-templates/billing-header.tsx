import { formatReceiptDateTime } from '@/lib/utils';
import { usePage } from '@inertiajs/react';

const BillingHeader = () => {
    const { billing, discountType, discountIdNo } = usePage().props as unknown as {
        billing: {
            transaction_no: string;
            visit: {
                patient: {
                    full_name: string;
                    control_no: string;
                    computed_age: string;
                    gender: {
                        name: 'string';
                    };
                    full_address: string;
                    age_computed: string;
                };
                consultation: {
                    doctor: {
                        full_name: string;
                        physician_last_name: string;
                    };
                };
            };
            created_at: string;
        };
        discountType: string;
        discountIdNo: string;
    };
    return (
        <>
            <table
                style={{
                    width: '450px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Bill #:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '40%' }}>
                            {billing.transaction_no ?? <>&nbsp;</>}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Physician:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '40%' }}>
                            {billing.visit.consultation?.doctor?.physician_last_name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Name:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '40%' }}>
                            {billing.visit.patient ? (
                                <>{billing.visit.patient?.full_name.toUpperCase()}</>
                            ) : (
                                'WALK-IN'
                            )}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Date:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '40%' }}>
                            {billing.created_at ? (
                                formatReceiptDateTime(billing.created_at, 'dateOnly')
                            ) : (
                                <>&nbsp;</>
                            )}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                style={{
                    width: '450px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '15%' }} className="fs-2 text-nowrap" align="left">
                            <span className="fw-bolder text-nowrap">Patient No:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '20%' }}>
                            {billing.visit.patient ? (
                                <>{billing.visit.patient?.control_no}</>
                            ) : (
                                <>&nbsp;</>
                            )}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Gender:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '25%' }}>
                            {billing.visit.patient?.gender?.name.toUpperCase() ?? <>&nbsp;</>}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '5%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Age:</span>
                        </td>
                        <td className="fw-bolder fs-2 pe-3 text-center" style={{ width: '25%' }}>
                            {billing.visit.patient?.age_computed?.toUpperCase() ?? <>&nbsp;</>}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                style={{
                    width: '450px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '10%' }} className="fs-2" align="left">
                            <span className="fw-bolder">Address:</span>
                        </td>
                        <td
                            className="fw-bolder fs-2 pe-3 text-center"
                            style={{ width: '90%' }}
                            colSpan={3}
                        >
                            {billing.visit.patient?.full_address?.toUpperCase() ?? <>&nbsp;</>}
                            <hr
                                className="border-dark border-2"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            {discountType && (
                <table
                    style={{
                        width: '450px',
                    }}
                >
                    <tbody>
                        <tr>
                            <td style={{ width: '18%' }} className="fs-2 text-nowrap" align="left">
                                <span className="fw-bolder text-nowrap">Discount Type:</span>
                            </td>
                            <td
                                className="fw-bolder fs-2 pe-3 text-center"
                                style={{ width: '32%' }}
                            >
                                {discountType ?? <>&nbsp;</>}
                                <hr
                                    className="border-dark border-2"
                                    style={{
                                        margin: '0',
                                    }}
                                />
                            </td>
                            <td style={{ width: '10%' }} className="fs-2" align="left">
                                <span className="fw-bolder">ID No:</span>
                            </td>
                            <td
                                className="fw-bolder fs-2 pe-3 text-center"
                                style={{ width: '40%' }}
                            >
                                {discountIdNo ?? <>&nbsp;</>}
                                <hr
                                    className="border-dark border-2"
                                    style={{
                                        margin: '0',
                                    }}
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            )}
        </>
    );
};

export default BillingHeader;
