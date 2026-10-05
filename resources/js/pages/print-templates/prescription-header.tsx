import { usePage } from '@inertiajs/react';

const PrescriptionHeader = () => {
    const { patient, consultDate } = usePage().props as unknown as {
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
    return (
        <>
            <table
                style={{
                    width: '450px',
                }}
            >
                <tbody>
                    <tr>
                        <td style={{ width: '62px' }}>Name:</td>
                        <td className="fw-bolder pe-3 text-center" style={{ width: '60%' }}>
                            {patient.full_name}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td style={{ width: '10%' }}>Date:</td>
                        <td className="fw-bolder pe-3 text-center" style={{ width: '20%' }}>
                            {consultDate ?? <>&nbsp;</>}
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
                        <td colSpan={3} className="fw-bolder pe-3 text-center">
                            {patient?.full_address ?? <>&nbsp;</>}
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
            <table style={{ width: '250px' }}>
                <tbody>
                    <tr>
                        <td align="left" style={{ width: '30px' }}>
                            Gender:
                        </td>
                        <td
                            className="fw-bolder text-center"
                            style={{
                                width: '30px',
                            }}
                        >
                            {patient.gender?.name ?? <>&nbsp;</>}
                            <hr
                                className="border-dark"
                                style={{
                                    margin: '0',
                                }}
                            />
                        </td>
                        <td align="left" width="10">
                            Age:
                        </td>
                        <td
                            className="fw-bolder text-center"
                            style={{
                                width: '50px',
                            }}
                        >
                            {patient?.age_computed ?? <>&nbsp;</>}
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

export default PrescriptionHeader;
