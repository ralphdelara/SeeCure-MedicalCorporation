import { IconTrash } from "@tabler/icons-react";
import { useState } from "react";
import { Button } from '@/components/ui/button';

export default () => {
    const [consultationDisplay, setConsultationDisplay] = useState('');

    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Consultation</h4>
                    <select className="form-select w-auto ms-auto" value={consultationDisplay}
                        onChange={(e) => setConsultationDisplay(e.target.value)}>
                        <option value="">All</option>
                        <option value="waiting">Waiting</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div className="table-responsive">
                    <table className="table stylish-table mb-0 text-nowrap consultation">
                        <thead>
                            <tr>
                                <th className="border-0 text-muted fw-normal" colSpan={2} style={{ width: '40%' }}>
                                    Patient
                                </th>
                                <th className="border-0 text-muted fw-normal" style={{ width: '40%' }}>
                                    Attending Doctor
                                </th>
                                <th className="border-0 text-muted fw-normal" style={{ width: '15%' }}>
                                    Status
                                </th>
                                <th style={{ width: '5%' }}></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className={consultationDisplay === '' || consultationDisplay === 'completed' ? '' : ' d-none'}>
                                <td style={{ width: '5%' }}>
                                    <span className="
                                                    round-40
                                                    text-white
                                                    d-flex
                                                    align-items-center
                                                    justify-content-center
                                                    text-center
                                                    rounded-circle
                                                    text-bg-info
                                                ">S</span>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Inna Damhnait</h6>
                                    <small className="text-muted">Headache...</small>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">
                                        Dr. Lyka Loraine Zulueta
                                    </h6>
                                    <small className="text-muted">RMT, MD</small>
                                </td>
                                <td>
                                    <span className="badge text-bg-success">Completed</span>
                                </td>
                                <td>
                                    <Button variant="danger" rounded={true} title="Delete">
                                        <i><IconTrash size={18}/></i>
                                    </Button>
                                </td>
                            </tr>
                            <tr className={consultationDisplay === '' || consultationDisplay === 'ongoing' ? '' : ' d-none'}>
                                <td>
                                    <span className="
                                                    round-40
                                                    text-white
                                                    d-flex
                                                    align-items-center
                                                    justify-content-center
                                                    text-center
                                                    rounded-circle
                                                    text-bg-info
                                                ">
                                        <img src="../assets/images/profile/user-3.jpg" alt="user" className="rounded-circle" width="40" />
                                    </span>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Malvina Amable</h6>
                                    <small className="text-muted">Fever..</small>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">
                                        Dr. Cherry Ann D. Distor
                                    </h6>
                                    <small className="text-muted">MD</small>
                                </td>
                                <td>
                                    <span className="badge text-bg-info">Ongoing</span>
                                </td>
                                <td>
                                    <Button variant="danger" rounded={true} title="Delete">
                                        <i><IconTrash size={18}/></i>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}