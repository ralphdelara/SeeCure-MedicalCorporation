import { usePage } from '@inertiajs/react';

const HeaderDetails = () => {
    const { patient, laboratory } = usePage().props as unknown as {
        laboratory: {
            created_at: string;
            date_performed: string;
        };
        patient: {
            full_name: string;
            computed_age: string;
            gender: {
                name: 'string';
            };
            civil_status: {
                name: 'string';
            };
            full_address: string;
        };
    };
    return (
        <>
            <table
                style={{
                    width: '700px',
                    marginTop: '10px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '50px' }}>Name:</td>
                        <td className="fw-bolder pe-3 text-center">
                            {patient.full_name}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '100px' }}>Date Requested:</td>
                        <td className="fw-bolder text-center" style={{ width: '150px' }}>
                            {new Intl.DateTimeFormat('en-US', {
                                month: 'short', // "Sep"
                                day: '2-digit', // "17"
                                year: 'numeric', // "2026"
                            }).format(new Date(laboratory.created_at))}
                            <hr
                                className="border-dark"
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
                    width: '700px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '50px' }}>Age:</td>
                        <td className="fw-bolder text-center">
                            {patient?.age_computed ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '50px', textAlign: 'right' }}>Sex:</td>
                        <td className="fw-bolder text-center">
                            {patient.gender?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '50px', textAlign: 'right' }}>CS:</td>
                        <td className="fw-bolder pe-3 text-center">
                            {patient.civil_status?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '100px' }}>Date Performed:</td>
                        <td className="fw-bolder text-center" style={{ width: '150px' }}>
                            {laboratory.date_performed ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
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
                    width: '700px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '50px' }}>Address:</td>
                        <td className="fw-bolder pe-3 text-center" style={{ width: '400px' }}>
                            {patient?.full_address ?? ''}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '100px', textAlign: 'right' }} className="pe-1">Physician:</td>
                        <td className="fw-bolder text-center">
                            &nbsp;
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </>
    );
};

export default HeaderDetails;
