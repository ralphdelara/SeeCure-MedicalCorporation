import { IconTrash } from "@tabler/icons-react";
import { useState } from "react";

export default () => {
    const [cashierDisplay, setcashierDisplay] = useState('');

    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Cashier</h4>
                    <select className="form-select w-auto ms-auto" value={cashierDisplay}
                        onChange={(e) => setcashierDisplay(e.target.value)}>
                        <option value="">All</option>
                        <option value="waiting">Waiting</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div className="table-responsive">
                    <table className="table stylish-table  mb-0 text-nowrap cashier">
                        <thead>
                            <tr>
                                <th className="border-0 text-muted fw-normal" colSpan={2} style={{ width: '40%' }}>
                                    Patient
                                </th>
                                <th className="border-0 text-muted fw-normal" style={{ width: '40%' }}>
                                    Personel
                                </th>
                                <th className="border-0 text-muted fw-normal" style={{ width: '15%' }}>
                                    Status
                                </th>
                                <th style={{ width: '5%' }}></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr className={cashierDisplay === '' || cashierDisplay === 'completed' ? '' : ' d-none'}>
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
                                        Véronique Ahmad
                                    </h6>
                                </td>
                                <td>
                                    <span className="badge text-bg-success">Completed</span>
                                </td>
                                <td>
                                    <button className="btn btn-sm btn-danger rounded-circle tooltip-container"
                                        data-title="Delete">
                                        <IconTrash/>
                                    </button>
                                </td>
                            </tr>
                            <tr className={cashierDisplay === '' || cashierDisplay === 'waiting' ? '' : ' d-none'}>
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
                                        Olga Yori
                                    </h6>
                                </td>
                                <td>
                                    <span className="badge text-bg-warning">Waiting</span>
                                </td>
                                <td>
                                    <button className="btn btn-sm btn-danger rounded-circle tooltip-container"
                                        data-title="Delete">
                                        <IconTrash/>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}