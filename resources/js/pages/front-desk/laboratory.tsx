import { IconTrash } from '@tabler/icons-react';
import { useState } from 'react';

export default () => {
    const [laboratoryDisplay, setlaboratoryDisplay] = useState('');

    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Laboratory</h4>
                    <select
                        className="form-select ms-auto w-auto"
                        value={laboratoryDisplay}
                        onChange={(e) => setlaboratoryDisplay(e.target.value)}
                    >
                        <option value="">All</option>
                        <option value="waiting">Waiting</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div className="table-responsive">
                    <table className="stylish-table laboratory mb-0 table text-nowrap">
                        <thead>
                            <tr>
                                <th
                                    className="fw-normal border-0 text-muted"
                                    colSpan={2}
                                    style={{ width: '40%' }}
                                >
                                    Patient
                                </th>
                                <th
                                    className="fw-normal border-0 text-muted"
                                    style={{ width: '40%' }}
                                >
                                    Personel
                                </th>
                                <th
                                    className="fw-normal border-0 text-muted"
                                    style={{ width: '15%' }}
                                >
                                    Status
                                </th>
                                <th style={{ width: '5%' }}></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                className={
                                    laboratoryDisplay === '' || laboratoryDisplay === 'completed'
                                        ? ''
                                        : 'd-none'
                                }
                            >
                                <td style={{ width: '5%' }}>
                                    <span className="round-40 d-flex align-items-center justify-content-center rounded-circle text-bg-info text-center text-white">
                                        S
                                    </span>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Inna Damhnait</h6>
                                    <small className="text-muted">Headache...</small>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Véronique Ahmad</h6>
                                    <small className="text-muted">RMT</small>
                                </td>
                                <td>
                                    <span className="badge text-bg-success">Completed</span>
                                </td>
                                <td>
                                    <button
                                        className="btn btn-sm btn-danger rounded-circle tooltip-container"
                                        data-title="Delete"
                                    >
                                        <IconTrash />
                                    </button>
                                </td>
                            </tr>
                            <tr
                                className={
                                    laboratoryDisplay === '' || laboratoryDisplay === 'waiting'
                                        ? ''
                                        : 'd-none'
                                }
                            >
                                <td>
                                    <span className="round-40 d-flex align-items-center justify-content-center rounded-circle text-bg-info text-center text-white">
                                        <img
                                            src="../assets/images/profile/user-3.jpg"
                                            alt="user"
                                            className="rounded-circle"
                                            width="40"
                                        />
                                    </span>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Malvina Amable</h6>
                                    <small className="text-muted">Fever..</small>
                                </td>
                                <td>
                                    <h6 className="fw-medium mb-0">Dr. Olga Yori</h6>
                                    <small className="text-muted">MD, Pathologist</small>
                                </td>
                                <td>
                                    <span className="badge text-bg-warning">Waiting</span>
                                </td>
                                <td>
                                    <button
                                        className="btn btn-sm btn-danger rounded-circle tooltip-container"
                                        data-title="Delete"
                                    >
                                        <IconTrash />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};
