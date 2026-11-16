import { IconBellRinging } from "@tabler/icons-react";
import personDefault from '@/assets/images/profile/person-default.png';

export default function HeaderNotifications() {
    return (
        <li className="nav-item nav-icon-hover-bg rounded-circle dropdown">
            <a
                className="nav-link position-relative"
                href="#"
                id="drop2"
                aria-expanded="false"
            >
                <IconBellRinging />
                <div className="notification rounded-circle bg-danger hidden"></div>
            </a>
            <div
                className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                aria-labelledby="drop2"
            >
                <div className="d-flex align-items-center justify-content-between px-7 py-3">
                    <h5 className="fs-5 fw-semibold mb-0">
                        Notifications
                    </h5>
                    <span className="badge text-bg-successrounded-4 lh-sm px-3 py-1">
                        5 new
                    </span>
                </div>
                <div className="message-body" data-simplebar>
                    <a
                        href="#"
                        className="d-flex align-items-center dropdown-item px-7 py-6"
                    >
                        <span className="me-3">
                            <img
                                src={personDefault}
                                alt="user"
                                className="rounded-circle"
                                width="48"
                                height="48"
                            />
                        </span>
                        <div className="w-100">
                            <h6 className="fw-semibold lh-base mb-1">
                                Roman Joined the Team!
                            </h6>
                            <span className="fs-2 d-block text-body-secondary">
                                Congratulate him
                            </span>
                        </div>
                    </a>
                    <a
                        href="javascript:void(0)"
                        className="d-flex align-items-center dropdown-item px-7 py-6"
                    >
                        <span className="me-3">
                            <img
                                src={personDefault}
                                alt="user"
                                className="rounded-circle"
                                width="48"
                                height="48"
                            />
                        </span>
                        <div className="w-100">
                            <h6 className="fw-semibold lh-base mb-1">
                                New message
                            </h6>
                            <span className="fs-2 d-block text-body-secondary">
                                Salma sent you new message
                            </span>
                        </div>
                    </a>
                </div>
                <div className="mb-1 px-7 py-6">
                    <button className="btn btn-outline-success w-100">
                        See All Notifications
                    </button>
                </div>
            </div>
        </li>
    );
}