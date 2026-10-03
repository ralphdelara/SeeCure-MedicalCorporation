import { formatReceiptDateTime } from '@/lib/utils';
import { usePage } from '@inertiajs/react';

const BillingHeader = () => {
    const { billing } = usePage().props as unknown as {
        billing: {
            visit: {
                patient: {
                    full_name: string;
                    computed_age: string;
                    gender: {
                        name: 'string';
                    };
                    full_address: string;
                    age_computed: string;
                };
            };
            created_at: string;
        };
    };
    return (
        <>
            <table
                style={{
                    width: '600px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '10%' }} align="left">
                            Name:
                        </td>
                        <td className="fw-bolder pe-3 text-center" style={{ width: '60%' }}>
                            {billing.visit.patient.full_name}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '10%' }} align="left">
                            Date:
                        </td>
                        <td className="fw-bolder pe-3 text-center" style={{ width: '20%' }}>
                            {billing.created_at ? (
                                formatReceiptDateTime(billing.created_at, 'dateOnly')
                            ) : (
                                <>&nbsp;</>
                            )}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td align="left">Address:</td>
                        <td colSpan={3} className="fw-bolder pe-3 text-center">
                            {billing.visit.patient?.full_address ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td align="left">Gender:</td>
                        <td className="fw-bolder text-center">
                            {billing.visit.patient.gender?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td align="left">Age:</td>
                        <td className="fw-bolder text-center">
                            {billing.visit.patient?.age_computed ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                    width: '83%',
                                }}
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default BillingHeader;
