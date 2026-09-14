import SuccessAnalyticsChart from '@/components/dashboard/column-chart';
import SuccessLineChart from '@/components/dashboard/line-chart';
import { usePage } from '@inertiajs/react';
import { IconFlask, IconMoneybag, IconPackageExport, IconPackageImport, IconScan, IconStethoscope, IconUser, IconUserHeart } from '@tabler/icons-react';

interface User {
    full_name: string;
    department: {
        name: string;
    };
}

export default function Dashboard() {
    const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
    const { auth } = usePage().props as unknown as {
        auth: { user: User; professions: string[]; specialties: string[] };
    };
    const { user, professions, specialties } = auth;
    const { full_name } = user;
    return (
        <>
            <div className="row w-100 ps-4">
                <div className="col-lg-4 d-flex align-items-stretch">
                    <div className="card text-bg-success w-100 border-0">
                        <div className="card-body pb-0">
                            <h2 className="fw-bolder mb-1 text-white">Welcome {user.first_name}</h2>
                            <p className="fs-5 fw-bold mb-3 text-white">{currentDate}</p>
                        </div>
                        <div className="card mt-n2 mx-2 mb-2">
                            <div className="card-body">
                                <div className="mb-7 pb-1">
                                    <div className="d-flex justify-content-between align-items-center mb-6">
                                        <div>
                                            <h6 className="fs-5 fw-semibold mb-1">
                                                Patient Visits
                                            </h6>
                                        </div>
                                        <div>
                                            <span className="badge bg-success-subtle fw-semibold fs-4 text-dark">
                                                1,000
                                            </span>
                                        </div>
                                    </div>
                                    <div className="progress bg-success-subtle h-4">
                                        <div
                                            className="progress-bar bg-success w-100"
                                            role="progressbar"
                                            aria-valuenow="75"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                                <div className="mb-7 pb-1">
                                    <div className="d-flex justify-content-between align-items-center mb-6">
                                        <div>
                                            <h6 className="fs-5 fw-semibold mb-1">Consultation</h6>
                                        </div>
                                        <div>
                                            <span className="badge bg-success-subtle fw-semibold fs-4 text-dark">
                                                1,000
                                            </span>
                                        </div>
                                    </div>
                                    <div className="progress bg-success-subtle h-4">
                                        <div
                                            className="progress-bar bg-success w-100"
                                            role="progressbar"
                                            aria-valuenow="75"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                                <div className="mb-7 pb-1">
                                    <div className="d-flex justify-content-between align-items-center mb-6">
                                        <div>
                                            <h6 className="fs-5 fw-semibold mb-1">Laboratory</h6>
                                        </div>
                                        <div>
                                            <span className="badge bg-success-subtle fw-semibold fs-4 text-dark">
                                                1,000
                                            </span>
                                        </div>
                                    </div>
                                    <div className="progress bg-success-subtle h-4">
                                        <div
                                            className="progress-bar bg-success w-100"
                                            role="progressbar"
                                            aria-valuenow="75"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                                <div className="mb-7 pb-1">
                                    <div className="d-flex justify-content-between align-items-center mb-6">
                                        <div>
                                            <h6 className="fs-5 fw-semibold mb-1">Radiology</h6>
                                        </div>
                                        <div>
                                            <span className="badge bg-success-subtle fw-semibold fs-4 text-dark">
                                                1,000
                                            </span>
                                        </div>
                                    </div>
                                    <div className="progress bg-success-subtle h-4">
                                        <div
                                            className="progress-bar bg-success w-100"
                                            role="progressbar"
                                            aria-valuenow="75"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-lg-2">
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconUserHeart size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Visits</p>
                                <h5 className="fw-semibold text-dark mb-0">3,650</h5>
                            </div>
                        </div>
                    </div>
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconUser size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Patients</p>
                                <h5 className="fw-semibold text-dark mb-0">3,650</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-lg-2">
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconStethoscope size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Consultations</p>
                                <h5 className="fw-semibold text-dark mb-0">3,650</h5>
                            </div>
                        </div>
                    </div>
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconMoneybag size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Collections</p>
                                <h5 className="fw-semibold text-dark mb-0">₱ 5,950</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-lg-2">
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconFlask size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Laboratory</p>
                                <h5 className="fw-semibold text-dark mb-0">3,650</h5>
                            </div>
                        </div>
                    </div>
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconPackageImport size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Stock In</p>
                                <h5 className="fw-semibold text-dark mb-0">3,650</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-lg-2">
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconScan size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Radiology</p>
                                <h5 className="fw-semibold text-dark mb-0">8,330</h5>
                            </div>
                        </div>
                    </div>
                    <div className="card bg-success-subtle border-0 shadow-none zoom-in">
                        <div className="card-body">
                            <div className="text-center">
                                <IconPackageExport size="80" className="text-success"/>
                                <p className="fw-semibold fs-5 text-dark mb-1">Stock Out</p>
                                <h5 className="fw-semibold text-dark mb-0">18,650</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row">
                <div className="col-lg-12">
                    <SuccessLineChart/>
                </div>
                </div>
            </div>
        </>
    );
}
