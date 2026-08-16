import { IconEdit } from "@tabler/icons-react";
import React from "react";
import { Link } from '@inertiajs/react';

const PatientInfo = ({ children }: {children: React.ReactNode}) => {
    return (
        <div className="card mt-2">
            <div className="card-body mb-0 p-0">
                <div className="row align-items-center w-100 g-3">
                    <div className="col-lg-3 order-lg-1 order-1">
                        <div>
                            <div className="d-flex align-items-center justify-content-center mb-2">
                                <div className="d-flex align-items-center justify-content-center round-110">
                                    <div className="d-flex align-items-center justify-content-center rounded-circle round-100 overflow-hidden border border-4 border-white">
                                        <img
                                            src="/assets/images/profile/user-1.jpg"
                                            alt="modernize-img"
                                            className="h-100 w-100"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-5 order-lg-2 order-2">

                            <div className="text-center text-dark fs-7 mb-0 fw-bolder">
                                Ralph Randahl Feliciano De Lara
                            </div>
                        <div className="d-flex align-items-center justify-content-around">
                            <div className="text-center p-2">
                                <i className="ti ti-file-description fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">20y 10m</h4>
                                <p className="mb-0">Age</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="text-center p-2">
                                <i className="ti ti-user-circle fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">Male</h4>
                                <p className="mb-0">Gender</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="text-center p-2">
                                <i className="ti ti-user-check fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">Discharged</h4>
                                <p className="mb-0">Status</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4 order-last">
                        <ul className="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end pe-xxl-4 mx-4 my-3 gap-3">
                            <li>
                                <Link className="btn btn-success text-nowrap">
                                    <IconEdit className="me-1"/>
                                    Update Profile
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
                {children}
            </div>
        </div>
    );
};

export default PatientInfo;
