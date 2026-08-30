import { IconEdit, IconTrash } from '@tabler/icons-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { usePage, Link } from '@inertiajs/react';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import { getUserDetails } from '@/actions/App/Http/Controllers/UserController';
import TableList from '@/components/table';

interface InertiaProps {
    incompleteConsultationList: {
        id: string;
        patient: {
            id: string;
            full_name: string;
            gender: {
                name: string;
            };
        };
        doctor: {
            full_name: string;
            gender: {
                name: string;
            };
        };
        status: {
            name: string;
        };
    }[];
    incompleteConsultationStatuses: {
        id: string;
        name: string;
    }[];
}

export default () => {
    const [consultationDisplay, setConsultationDisplay] = useState('');
    const { incompleteConsultationList, incompleteConsultationStatuses } = usePage()
        .props as unknown as InertiaProps;
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: 'Attending Doctor', align: 'left' },
        { name: '', className: 'sticky-right', align: 'right' },
    ];

    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Consultation</h4>
                </div>
                <TableList header={header}>
                    {incompleteConsultationList.map((item, index) => (
                        <tr key={'front-desk-list-' + item.id}>
                            <td className="text-right">
                                <h5>{index + 1}</h5>
                            </td>
                            <td>
                                <div className="d-block">
                                    <div className="d-flex align-items-center">
                                        <div style={{ width: '40px' }}>
                                            <img
                                                className="rounded-circle"
                                                width="40"
                                                height="40"
                                                src="../assets/images/profile/user-2.jpg"
                                            />
                                        </div>
                                        <div className="ms-3">
                                            <h6 className="fs-4 fw-semibold mb-0">
                                                <Link
                                                    href={getPatientDetails(item.patient.id)}
                                                    className="tooltip-container"
                                                    data-title="Click to View Patient Details"
                                                >
                                                    {item.patient.full_name}
                                                </Link>
                                            </h6>
                                            <span className="fw-normal">
                                                {item.patient.gender
                                                    ? item.patient.gender.name
                                                    : 'N/A'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div className="d-block">
                                    <div className="d-flex align-items-center">
                                        <div style={{ width: '40px' }}>
                                            <img
                                                className="rounded-circle"
                                                width="40"
                                                height="40"
                                                src="../assets/images/profile/user-2.jpg"
                                            />
                                        </div>
                                        <div className="ms-3">
                                            <h6 className="fs-4 fw-semibold mb-0">
                                                {item.doctor.full_name}
                                            </h6>
                                            <span className="fw-normal">
                                                {item.doctor.gender
                                                    ? item.doctor.gender.name
                                                    : 'N/A'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <Button
                                    rounded={true}
                                    className="me-2"
                                    title="Edit Queue Details"
                                >
                                    <i>
                                        <IconEdit size={18} />
                                    </i>
                                </Button>
                                <Button variant="danger" rounded={true} title="Delete">
                                    <i>
                                        <IconTrash size={18} />
                                    </i>
                                </Button>
                            </td>
                        </tr>
                    ))}
                    {incompleteConsultationList.length === 0 && (
                        <tr>
                            <td colSpan={4} className="fs-7 text-danger text-center">
                                No records
                            </td>
                        </tr>
                    )}
                </TableList>
            </div>
        </div>
    );
};
