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
                }}
            >
                <tbody>
                    <tr>
                        <td>Name:</td>
                        <td colSpan={5} className="fw-bolder pe-3 text-center">
                            {patient.full_name}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td>Date Requested:</td>
                        <td className="fw-bolder text-center">
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
                    <tr>
                        <td>Age:</td>
                        <td className="fw-bolder text-center">
                            {patient?.age_computed ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    width: '70px',
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td>Sex:</td>
                        <td className="fw-bolder text-center">
                            {patient.gender?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    width: '70px',
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td>CS:</td>
                        <td className="fw-bolder text-center">
                            {patient.civil_status?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    width: '70px',
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td>Date Performed:</td>
                        <td className="fw-bolder text-center">
                            {laboratory.date_performed ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td colSpan={5} className="fw-bolder pe-3 text-center">
                            {patient?.full_address ?? ''}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td>Physician:</td>
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
