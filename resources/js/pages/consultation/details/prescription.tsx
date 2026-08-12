import { Head } from '@inertiajs/react';

const Prescription = () => {
    return (
        <>
            <Head title="Prescription" />
            <div className="tab-content mt-3">
                <div
                    className="tab-pane fade show active"
                    role="tabpanel"
                    tabIndex={4}
                >
                    <div className="row">
                        <div className="col-lg-4">
                            <div className="card border shadow-none">
                                <div className="card-body">
                                    <h4 className="mb-3">Prescription</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Prescription;
