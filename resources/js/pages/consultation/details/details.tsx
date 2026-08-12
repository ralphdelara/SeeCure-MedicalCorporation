import { Label } from "@/components/ui/label";
import { Head } from "@inertiajs/react";

const Details = () => {
    return (
        <>
            <Head title="Consultation Details"/>
            <div className="tab-content mt-3">
                <div
                    className="tab-pane fade show active"
                    role="tabpanel"
                    tabIndex={1}
                >
                    <div className="row w-100">
                        <div className="col-lg-12">
                            <div className="card border shadow-sm">
                                <div className="card-body">
                                    <h4 className="mb-3">Consultation Details</h4>

                                    <div className="form-group">
                                        <Label htmlFor="medicalServices">
                                            <h5 className="fw-bolder">Medical Services</h5>
                                        </Label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Details;