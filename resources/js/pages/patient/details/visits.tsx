import { Head, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { PatientDetailsProps } from '@/components/patient/patient-details';
import VisitDetailsModal from './visit-details-modal';

interface InertiaProps {
    patientDetails: PatientDetailsProps;
}

const Visits = () => {
    const header = [
        { name: '#', align: 'right' },
        { name: 'Added By', align: 'left' },
        { name: 'Emergency', align: 'left' },
        { name: 'Priority', align: 'left' },
        { name: 'Services', align: 'left' },
        { name: 'Status', align: 'left' },
        { name: '', align: 'left' },
    ];
    const { patientDetails } = usePage().props as unknown as InertiaProps;
    const { visits } = patientDetails;

    return (
        <>
            <Head title="Visits" />
            <div className="tab-content mt-3">
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={2}>
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row w-100">
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Visits</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {visits.map((item, index) => (
                                        <tr key={'visit-tr-' + index}>
                                            <td className="text-right">
                                                <h5>{index + 1}</h5>
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.created_by.full_name}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.created_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {item.is_emergency && (
                                                    <span className="badge bg-success">Yes</span>
                                                )}
                                                {!item.is_emergency && (
                                                    <span className="badge bg-danger">No</span>
                                                )}
                                            </td>

                                            <td>
                                                {item.priority_types.map(
                                                    (priority, priorityIndex) => (
                                                        <>
                                                            {priorityIndex > 0 && <br />}
                                                            <span
                                                                className={
                                                                    'badge bg-info' +
                                                                    (priorityIndex > 0
                                                                        ? ' mt-1'
                                                                        : '')
                                                                }
                                                            >
                                                                {priority.name}
                                                            </span>
                                                        </>
                                                    ),
                                                )}
                                                {item.priority_types.length === 0 && (
                                                    <span className="badge bg-danger">None</span>
                                                )}
                                            </td>
                                            <td>
                                                {item.has_consultation && (
                                                    <p className="mt-1 mb-0">
                                                        <span className="badge bg-success">
                                                            Consultation
                                                        </span>
                                                    </p>
                                                )}
                                                {item.has_laboratory && (
                                                    <p className="mt-1 mb-0">
                                                        <span className="badge bg-success">
                                                            Laboratory
                                                        </span>
                                                    </p>
                                                )}
                                                {item.has_radiology && (
                                                    <p className="mt-1 mb-0">
                                                        <span className="badge bg-success">
                                                            Radiology
                                                        </span>
                                                    </p>
                                                )}
                                            </td>
                                            <td>
                                                <h5>{item.status.name}</h5>
                                            </td>
                                            <td>
                                                <VisitDetailsModal visit={item} />
                                            </td>
                                        </tr>
                                    ))}
                                    {visits.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan={7}
                                                className="fs-5 text-danger text-center"
                                            >
                                                No record
                                            </td>
                                        </tr>
                                    )}
                                </TableList>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Visits;
