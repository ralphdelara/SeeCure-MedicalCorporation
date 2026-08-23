import { IconUserEdit } from '@tabler/icons-react';
import React from 'react';
import { Link } from '@inertiajs/react';
import { getUserDetails } from '@/actions/App/Http/Controllers/UserController';
import { UserDetailsProps } from '@/components/user/user-details';

interface InertiaProps {
    userDetails: UserDetailsProps;
    children: React.ReactNode;
}

const UserInfo = ({ userDetails, children }: InertiaProps) => {
    return (
        <div className="card mt-2">
            <div className="card-body mb-0 p-0">
                <div className="row align-items-center g-3 w-100">
                    <div className="col-lg-1 order-lg-1 order-1">
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
                    <div className="col-lg-10 order-lg-2 order-2">
                        <div className="text-dark fs-7 fw-bolder mb-0 text-center">
                            {userDetails.full_name}
                        </div>
                        <div className="d-flex align-items-center justify-content-around">
                            <div className="p-2 text-center">
                                <i className="ti ti-file-description fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">{userDetails.age ?? 'N/A'}</h4>
                                <p className="mb-0">Age</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="p-2 text-center">
                                <i className="ti ti-user-circle fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">
                                    {userDetails.gender?.name ?? 'N/A'}
                                </h4>
                                <p className="mb-0">Gender</p>
                            </div>
                            <div className="border-end border-success">&nbsp;</div>
                            <div className="p-2 text-center">
                                <i className="ti ti-user-check fs-6 d-block mb-2"></i>
                                <h4 className="lh-1 mb-0">
                                    {userDetails.status?.name ?? 'N/A'}
                                </h4>
                                <p className="mb-0">Status</p>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-1 order-last">
                        <ul className="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-end pe-xxl-4 mx-4 my-3 gap-3">
                            <li>
                                <Link
                                    href={getUserDetails(userDetails.id).url}
                                    className="btn btn-success text-nowrap"
                                >
                                    <IconUserEdit className="me-1" />
                                    View Details
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

export default UserInfo;
