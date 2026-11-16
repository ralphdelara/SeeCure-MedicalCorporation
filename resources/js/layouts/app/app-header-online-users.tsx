import { onlineUsersPage } from '@/routes';
import { IconUserShield } from '@tabler/icons-react';
import { useState } from 'react';
import OnlineUsers from '@/pages/sockets/online-users';
import personDefault from '@/assets/images/profile/person-default.png';
import { Link } from '@inertiajs/react';

export default function HeaderOnlineUsers() {
    const [onlineUsers, setOnlineUsers] = useState<{
        id: string;
        full_name: string;
        position: string;
    }[]>([]);
    return (
        <li className="nav-item nav-icon-hover-bg rounded-circle dropdown">
            <OnlineUsers setOnlineUsers={setOnlineUsers} />
            <a
                className="nav-link position-relative"
                href="#"
                id="drop2"
                aria-expanded="false"
            >
                <IconUserShield />
                <div className="notification rounded-circle bg-success"></div>
            </a>
            <div
                className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                aria-labelledby="drop2"
            >
                <div className="d-flex align-items-center justify-content-between px-7 py-3">
                    <h5 className="fs-5 fw-semibold mb-0">
                        Online Users
                    </h5>
                    <span className="badge text-bg-success rounded-4 lh-sm px-3 py-1">
                        {onlineUsers.length} online
                    </span>
                </div>
                <div>
                    {onlineUsers.map((item, index) => {
                        if (index > 4) {
                            return;
                        }
                        return (
                            <a
                                href="#"
                                className="d-flex align-items-center dropdown-item px-7 py-6"
                                key={'header-online-user-' + index}
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
                                        {item.full_name}
                                    </h6>
                                    <span className="fs-2 d-block text-body-secondary">
                                        {item.position}
                                    </span>
                                </div>
                            </a>
                        )
                    })}
                    {onlineUsers.length === 0 && (
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
                                <h2>No online users</h2>
                            </div>
                        </a>
                    )}
                </div>
                <div className="mb-1 px-7 py-6">
                    <Link href={onlineUsersPage().url} className="btn btn-outline-success w-100">
                        See All Online Users
                    </Link>
                </div>
            </div>
        </li>
    );
}