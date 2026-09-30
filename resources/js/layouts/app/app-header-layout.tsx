import { Link, usePage } from '@inertiajs/react';
import { IconBellRinging, IconDots, IconLogout, IconMenu2, IconSearch } from '@tabler/icons-react';
import { Fragment, useEffect, useState } from 'react';
import logoText from '@/assets/images/logos/logo_text.png';
import { calendar, frontDesk, logout, notes, reminders, guide } from '@/routes';
import NotifyDoctor from '@/pages/notifications/notify-doctor';
import personDefault from '@/assets/images/profile/person-default.png';
import NotifyBilling from '@/pages/notifications/notify-billing';
import NotifyPharmacy from '@/pages/notifications/notify-pharmacy';
import NotifyCashier from '@/pages/notifications/notify-cashier';
import NotifyLaboratory from '@/pages/notifications/notify-laboratory';
import NotifyRadiology from '@/pages/notifications/notify-radiology';
import NotifyFrontDesk from '@/pages/notifications/notify-front-desk';

type NavHeaderProps = {
    toggleSidebar: () => void;
};

interface User {
    full_name: string;
    departments: {
        name: string;
    }[];
}

export default function NavHeader({ toggleSidebar }: NavHeaderProps) {
    const { url } = usePage();
    const [showTopNav, setShowTopNav] = useState(false);
    const { auth, warning } = usePage().props as unknown as {
        auth: { user: User; professions: string[]; specialties: string[] };
        warning: {
            title: string;
            msg: string;
        };
    };
    const { user, professions, specialties } = auth;
    const { full_name } = user;
    const routes = [
        { url: guide(), name: 'Guide' },
        { url: notes(), name: 'Notes' },
        { url: reminders(), name: 'Reminders' },
        { url: calendar(), name: 'Calendar' },
    ];

    useEffect(() => {
        window.addEventListener('scroll', function () {
            const topbar = document.querySelector('.topbar');

            if (topbar) {
                if (window.scrollY >= 60) {
                    topbar.classList.add('shadow-sm');
                } else {
                    topbar.classList.remove('shadow-sm');
                }
            }
        });
    }, []);

    return (
        <>
            <header className="topbar">
                <div className="with-vertical">
                    <nav className="navbar navbar-expand-lg p-0">
                        <ul className="navbar-nav">
                            <li className="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                                <button
                                    onClick={() => toggleSidebar()}
                                    className="nav-link sidebartoggler"
                                    id="headerCollapse"
                                >
                                    <IconMenu2 />
                                </button>
                            </li>
                            <li className="nav-item nav-icon-hover-bg rounded-circle d-none d-lg-flex">
                                <a
                                    className="nav-link"
                                    href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                >
                                    <IconSearch />
                                </a>
                            </li>
                        </ul>

                        <ul className="navbar-nav quick-links d-none d-lg-flex align-items-center">
                            {routes.map((item, index) => (
                                <li
                                    className="nav-item dropdown-hover d-none d-lg-block"
                                    key={'header-nav-' + index}
                                >
                                    <Link className="nav-link" href={item.url}>
                                        {item.name}
                                    </Link>
                                </li>
                            ))}
                        </ul>

                        <div className="d-block d-lg-none py-4">
                            <a href="../main/index.html" className="logo-img text-nowrap">
                                <img src={logoText} className="dark-logo" width="170" />
                            </a>
                        </div>
                        <button
                            onClick={() => setShowTopNav(true)}
                            className="navbar-toggler nav-icon-hover-bg rounded-circle mx-0 border-0 p-0"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarNav"
                            aria-controls="navbarNav"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                        >
                            <IconDots className="fs-7" />
                        </button>
                        <div
                            className={
                                'navbar-collapse justify-content-end' +
                                (!showTopNav ? ' d-none' : '') +
                                ' d-lg-block'
                            }
                            id="navbarNav"
                        >
                            <div className="d-flex align-items-center justify-content-between">
                                <a
                                    href="javascript:void(0)"
                                    className="nav-link nav-icon-hover-bg rounded-circle ms-n1 d-flex d-lg-none align-items-center justify-content-center mx-0"
                                    type="button"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#mobilenavbar"
                                    aria-controls="offcanvasWithBothOptions"
                                >
                                    <i className="ti ti-align-justified fs-7"></i>
                                </a>
                                <ul className="navbar-nav align-items-center justify-content-center ms-auto flex-row">
                                    <li className="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                        <a
                                            className="nav-link position-relative"
                                            href="javascript:void(0)"
                                            id="drop2"
                                            aria-expanded="false"
                                        >
                                            <i className="ti ti-bell-ringing"></i>
                                            <IconBellRinging />
                                            <div className="notification rounded-circle bg-primary"></div>
                                        </a>
                                        <div
                                            className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2"
                                        >
                                            <div className="d-flex align-items-center justify-content-between px-7 py-3">
                                                <h5 className="fs-5 fw-semibold mb-0">
                                                    Notifications
                                                </h5>
                                                <span className="badge text-bg-primary rounded-4 lh-sm px-3 py-1">
                                                    5 new
                                                </span>
                                            </div>
                                            <div className="message-body" data-simplebar>
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
                                                <button className="btn btn-outline-primary w-100">
                                                    See All Notifications
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <li className="nav-item dropdown">
                                        <a
                                            className="nav-link pe-0"
                                            href="#"
                                            id="drop1"
                                            aria-expanded="false"
                                        >
                                            <div className="d-flex align-items-center">
                                                <div className="user-profile-img">
                                                    <img
                                                        src={personDefault}
                                                        className="rounded-circle"
                                                        width="35"
                                                        height="35"
                                                        alt="modernize-img"
                                                    />
                                                </div>
                                            </div>
                                        </a>
                                        <div
                                            className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1"
                                        >
                                            <div
                                                className="profile-dropdown position-relative"
                                                data-simplebar
                                            >
                                                <div className="px-7 py-3 pb-0">
                                                    <h5 className="fs-5 fw-semibold mb-0">
                                                        User Profile
                                                    </h5>
                                                </div>
                                                <div className="d-flex align-items-center border-bottom mx-7 py-9">
                                                    <img
                                                        src={personDefault}
                                                        className="rounded-circle"
                                                        width="80"
                                                        height="80"
                                                        alt="modernize-img"
                                                    />
                                                    <div className="ms-3">
                                                        <h4 className="fs-3 mb-1">{full_name}</h4>
                                                        <span className="d-block mb-1">
                                                            {professions}
                                                        </span>
                                                        <span className="d-block mb-1">
                                                            {specialties}
                                                        </span>
                                                        <p className="d-flex align-items-center mb-0 gap-2">
                                                            <i className="ti ti-mail fs-4"></i>{' '}
                                                            <a
                                                                href="/cdn-cgi/l/email-protection"
                                                                className="__cf_email__"
                                                                data-cfemail="b3daddd5dcf3dedcd7d6c1dddac9d69dd0dcde"
                                                            >
                                                                [email&#160;protected]
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="message-body">
                                                    <a
                                                        href="/main/page-user-profile.html"
                                                        className="d-flex align-items-center mt-8 px-7 py-8"
                                                    >
                                                        <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img
                                                                src={personDefault}
                                                                alt="modernize-img"
                                                                width="24"
                                                                height="24"
                                                            />
                                                        </span>
                                                        <div className="w-100 ps-3">
                                                            <h6 className="fs-3 fw-semibold lh-base mb-1">
                                                                My Profile
                                                            </h6>
                                                            <span className="fs-2 d-block text-body-secondary">
                                                                Account Settings
                                                            </span>
                                                        </div>
                                                    </a>
                                                    <a
                                                        href="/main/app-email.html"
                                                        className="d-flex align-items-center px-7 py-8"
                                                    >
                                                        <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img
                                                                src={personDefault}
                                                                alt="modernize-img"
                                                                width="24"
                                                                height="24"
                                                            />
                                                        </span>
                                                        <div className="w-100 ps-3">
                                                            <h6 className="fs-3 fw-semibold lh-base mb-1">
                                                                My Inbox
                                                            </h6>
                                                            <span className="fs-2 d-block text-body-secondary">
                                                                Messages & Emails
                                                            </span>
                                                        </div>
                                                    </a>
                                                    <a
                                                        href="/main/app-notes.html"
                                                        className="d-flex align-items-center px-7 py-8"
                                                    >
                                                        <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                            <img
                                                                src={personDefault}
                                                                alt="modernize-img"
                                                                width="24"
                                                                height="24"
                                                            />
                                                        </span>
                                                        <div className="w-100 ps-3">
                                                            <h6 className="fs-3 fw-semibold lh-base mb-1">
                                                                My Task
                                                            </h6>
                                                            <span className="fs-2 d-block text-body-secondary">
                                                                To-do and Daily Tasks
                                                            </span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div className="d-grid px-7 py-4 pt-8">
                                                    <Link
                                                        href={logout().url}
                                                        method="post"
                                                        as="button"
                                                        className="btn btn-success"
                                                    >
                                                        <IconLogout className="me-1" size={20} />
                                                        Log Out
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
            {user.departments.map((item, index) => (
                <Fragment key={'dept-notify-' + index}>
                    {item.name === 'Consultation' && <NotifyDoctor />}
                    {item.name === 'Billing' && <NotifyBilling />}
                    {item.name === 'Pharmacy' && <NotifyPharmacy />}
                    {item.name === 'Cashier' && <NotifyCashier />}
                    {item.name === 'Laboratory' && <NotifyLaboratory />}
                    {item.name === 'Radiology' && <NotifyRadiology />}
                </Fragment>
            ))}
            {url.includes(frontDesk().url) && <NotifyFrontDesk />}

            {(warning?.title ?? '') !== '' && (
                <div
                    className="badge bg-warning system-warning"
                    style={{
                        zIndex: '99999',
                        position: 'fixed',
                        bottom: '0',
                        right: '0',
                        marginBottom: '20px',
                        marginRight: '20px',
                        color: '#000',
                        textAlign: 'left',
                    }}
                >
                    <div className="d-flex p-3">
                        <div>
                            <div className="system-warning-icon" />
                        </div>
                        <div>
                            <h4 className="fw-bolder">
                                {warning.title} - <b>{warning.current}</b> out of{' '}
                                <b>{warning.total}</b> records
                            </h4>
                            <h5>{warning.msg}</h5>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
