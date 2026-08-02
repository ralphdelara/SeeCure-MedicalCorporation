import { useState } from "react";

export default () => {
    return (
        <div className="card">
            <div className="card-body">
                <div className="d-flex align-items-center">
                    <h4 className="card-title">Queue</h4>
                </div>
                <div className="table-responsive">
                    <table className="table stylish-table  mb-0 text-nowrap consultation">
                        <thead>
                            <tr>
                                <th className="border-0 text-muted fw-normal" style={{ width: '85%' }}>
                                    Patient
                                </th>
                                <th className="border-0 text-muted fw-normal" style={{ width: '15%' }}>
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h6 className="fw-medium mb-0">Sara Marcianus</h6>
                                </td>
                                <td>
                                    <span className="badge text-bg-success">Now</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 className="fw-medium mb-0">Inna Damhnait</h6>
                                    <small className="text-muted">Headache...</small>
                                </td>
                                <td>
                                    <span className="badge text-bg-info">Next</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}