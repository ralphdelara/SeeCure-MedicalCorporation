import { Head } from '@inertiajs/react';
import TableList from '@/components/table';
import { Fragment } from 'react';
import TableAccordion from '@/components/table-accordion';

const Visits = () => {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Visit DateTime', width: '30%', align: 'left' },
        { name: 'Services', width: '30%', align: 'left' },
        { name: 'Added By', width: '30%', align: 'left' },
    ];

    const tableData = [];

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
                                    <Fragment key={''}>
                                        <tr>
                                            <td className="fs-5 text-right">1</td>
                                            <td className="fs-5">
                                                <small>Jul 30, 2020 09:30am</small>
                                            </td>
                                            <td className="fs-5">
                                                <span className="badge text-bg-secondary">
                                                    Consultation
                                                </span>
                                            </td>
                                            <td className="fs-5 align-top">
                                                <b>Encoder Name</b>
                                            </td>
                                        </tr>
                                        <TableAccordion uuid={'cons'} label="Consultation" cols={8}>
                                            <span className="fs-4 text-center text-danger">No Consultation record</span>
                                        </TableAccordion>
                                        <TableAccordion uuid={'lab'} label="Laboratory" cols={8}>
                                            <span className="fs-4 text-center text-danger">No Laboratory record</span>
                                        </TableAccordion>
                                        <TableAccordion uuid={'rad'} label="Radiology" cols={8}>
                                            <span className="fs-4 text-center text-danger">No Radiology record</span>
                                        </TableAccordion>
                                    </Fragment>
                                    {tableData.length === 0 && (
                                        <tr>
                                            <td colSpan={4} className="fs-5 text-center text-danger">
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
