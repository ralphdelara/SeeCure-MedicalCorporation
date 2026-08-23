import { Head } from '@inertiajs/react';

const AuditLog = () => {
    return (
        <>
            <Head title="Audit Log" />
            <div className="tab-content mt-3">
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="mb-4">
                                <h4 className="card-title fw-semibold">Audit Log</h4>
                                <p className="card-subtitle">
                                    Automated, time-stamped record of system and user activities
                                </p>
                            </div>
                            <div className="row border-bottom border-success p-3">
                                <div className="col-lg-3 fs-5 text-dark">
                                    <b>Check Out</b>
                                </div>
                                <div className="col-lg-6 fs-5 text-dark">User Checked Out</div>
                                <div className="col-lg-3">
                                    <div className="timeline-desc fs-5 text-dark mt-n1">
                                        <b>Dr. Sarah Jenkins, M.D.</b>
                                        <br />
                                        <small>Jul 30, 2020 09:30am</small>
                                    </div>
                                </div>
                            </div>
                            <div className="row border-bottom border-success p-3">
                                <div className="col-lg-3 fs-5 text-dark">
                                    <b>Check Out</b>
                                </div>
                                <div className="col-lg-6 fs-5 text-dark">User Checked Out</div>
                                <div className="col-lg-3">
                                    <div className="timeline-desc fs-5 text-dark mt-n1">
                                        <b>Dr. Sarah Jenkins, M.D.</b>
                                        <br />
                                        <small>Jul 30, 2020 09:30am</small>
                                    </div>
                                </div>
                            </div>
                            <div className="row border-bottom border-success p-3">
                                <div className="col-lg-3 fs-5 text-dark">
                                    <b>Check Out</b>
                                </div>
                                <div className="col-lg-6 fs-5 text-dark">User Checked Out</div>
                                <div className="col-lg-3">
                                    <div className="timeline-desc fs-5 text-dark mt-n1">
                                        <b>Dr. Sarah Jenkins, M.D.</b>
                                        <br />
                                        <small>Jul 30, 2020 09:30am</small>
                                    </div>
                                </div>
                            </div>
                            <div className="row border-bottom border-success p-3">
                                <div className="col-lg-3 fs-5 text-dark">
                                    <b>Add</b>
                                </div>
                                <div className="col-lg-6 fs-5 text-dark">Added this user</div>
                                <div className="col-lg-3">
                                    <div className="timeline-desc fs-5 text-dark mt-n1">
                                        <b>Dr. Sarah Jenkins, M.D.</b>
                                        <br />
                                        <small>Jul 30, 2020 09:30am</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default AuditLog;
