import { IconEdit, IconTrash } from '@tabler/icons-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { usePage, Link } from '@inertiajs/react';
import { getPatientDetails } from '@/actions/App/Http/Controllers/PatientController';
import TableList from '@/components/table';
import DeleteButton from '@/components/delete-button';
import { deleteQueue } from '@/actions/App/Http/Controllers/FrontDeskController';
import personDefault from '@/assets/images/profile/person-default.png';

interface InertiaProps {
    consultationList: {
        id: string;
        patient: {
            id: string;
            full_name: string;
            gender: {
                name: string;
            };
        };
        consultation: {
            doctor: {
                full_name: string;
                gender: {
                    name: string;
                };
            };
        };
        status: {
            name: string;
        };
    }[];
}

export default ({ consultationList }: { consultationList: any[]}) => {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient • Gender', className: 'sticky-left', align: 'left' },
        { name: '', width: '5%', className: 'sticky-right', align: 'right' },
    ];

    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Consultation</h4>
                </div>
                <div className="overflow-y-auto" style={{ maxHeight: '350px' }}>
                    <TableList header={header}>
                        {consultationList.map((item, index) => (
                            <tr key={'front-desk-consult-list-' + item.id}>
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
                                                    src={personDefault}
                                                />
                                            </div>
                                            <div className="ms-3">
                                                {item.patient ? (
                                                    <>
                                                        <h6 className="fs-4 fw-semibold mb-0">
                                                            <Link
                                                                href={getPatientDetails(
                                                                    item.patient?.id,
                                                                )}
                                                                className="tooltip-container"
                                                                data-title="Click to View Patient Details"
                                                            >
                                                                {item.patient?.full_name}
                                                            </Link>
                                                        </h6>
                                                        <span className="fw-normal">
                                                            {item.patient?.gender
                                                                ? item.patient.gender.name
                                                                : 'N/A'}
                                                        </span>
                                                    </>
                                                ) : (
                                                    <h6 className="fs-4 fw-semibold mb-0">
                                                        WALK-IN
                                                    </h6>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <DeleteButton
                                        url={deleteQueue(item.id).url}
                                        msg={'visit <b>' + item.patient?.full_name + '</b>.'}
                                    />
                                </td>
                            </tr>
                        ))}
                        {consultationList.length === 0 && (
                            <tr>
                                <td colSpan={4} className="fs-7 text-danger text-center">
                                    No records
                                </td>
                            </tr>
                        )}
                    </TableList>
                </div>
            </div>
        </div>
    );
};
