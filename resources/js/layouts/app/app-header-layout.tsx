import logoText from '@/assets/images/logos/logo_text.png';
import { announcements, calendar, notes, reminders } from '@/routes';
import { Link, usePage } from '@inertiajs/react';
import { IconBellRinging, IconMenu, IconMenu2, IconSearch } from '@tabler/icons-react';
import { useState } from 'react';

type NavHeaderProps = {
    toggleSidebar: () => void;
}

interface AuthStructure {
    user: User;
    professions: object;
    specialties: object;
    departments: object;
}

interface User {
    first_name: string;
    last_name: string;
}

export default function NavHeader({ toggleSidebar }: NavHeaderProps) {
    const [showTopNav, setShowTopNav] = useState(false);
    const { auth } = usePage().props as unknown as { auth: { user: User } };
    const { user, professions, specialties, departments } = auth;
    const { first_name, last_name } = user;
    const routes = [
        {url: announcements(), name: 'Announcements'},
        {url: notes(), name: 'Notes'},
        {url: reminders(), name: 'Reminders'},
        {url: calendar(), name: 'Calendar'},
    ];

    return (
        <header className="topbar">
            <div className="with-vertical">
                <nav className="navbar navbar-expand-lg p-0">
                    <ul className="navbar-nav">
                        <li className="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                            <button onClick={() => toggleSidebar()} className="nav-link sidebartoggler" id="headerCollapse">
                                <i className="ti ti-menu-2"></i>
                                <IconMenu2/>
                            </button>
                        </li>
                        <li className="nav-item nav-icon-hover-bg rounded-circle d-none d-lg-flex">
                            <a className="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <IconSearch/>
                            </a>
                        </li>

                    </ul>

                    <ul className="navbar-nav quick-links d-none d-lg-flex align-items-center">
                        {routes.map((item, index) => (
                        <li className="nav-item dropdown-hover d-none d-lg-block" key={'header-nav-' + index}>
                            <Link className="nav-link" href={item.url}>{item.name}</Link>
                        </li>
                        ))}
                    </ul>

                    <div className="d-block d-lg-none py-4">
                        <a href="../main/index.html" className="text-nowrap logo-img">
                            <img src={logoText} className="dark-logo" width="170" />
                        </a>
                    </div>
                    <button onClick={() => setShowTopNav(true)} className="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i className="ti ti-dots fs-7"></i>
                    </button>
                    <div className={"navbar-collapse justify-content-end" + (!showTopNav ? " d-none" : "") + " d-lg-block"} id="navbarNav">
                        <div className="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0)" className="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                                <i className="ti ti-align-justified fs-7"></i>
                            </a>
                            <ul className="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                <li className="nav-item nav-icon-hover-bg rounded-circle dropdown">
                                    <a className="nav-link position-relative" href="javascript:void(0)" id="drop2" aria-expanded="false">
                                        <i className="ti ti-bell-ringing"></i>
                                        <IconBellRinging/>
                                        <div className="notification bg-primary rounded-circle"></div>
                                    </a>
                                    <div className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                        <div className="d-flex align-items-center justify-content-between py-3 px-7">
                                            <h5 className="mb-0 fs-5 fw-semibold">Notifications</h5>
                                            <span className="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                                        </div>
                                        <div className="message-body" data-simplebar>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-2.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                                                    <span className="fs-2 d-block text-body-secondary">Congratulate him</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-3.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">New message</h6>
                                                    <span className="fs-2 d-block text-body-secondary">Salma sent you new message</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-4.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">Bianca sent payment</h6>
                                                    <span className="fs-2 d-block text-body-secondary">Check your earnings</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-5.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">Jolly completed tasks</h6>
                                                    <span className="fs-2 d-block text-body-secondary">Assign her new tasks</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-6.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">John received payment</h6>
                                                    <span className="fs-2 d-block text-body-secondary">$230 deducted from account</span>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)" className="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span className="me-3">
                                                    <img src="/assets/images/profile/user-7.jpg" alt="user" className="rounded-circle" width="48" height="48" />
                                                </span>
                                                <div className="w-100">
                                                    <h6 className="mb-1 fw-semibold lh-base">Roman Joined the Team!</h6>
                                                    <span className="fs-2 d-block text-body-secondary">Congratulate him</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div className="py-6 px-7 mb-1">
                                            <button className="btn btn-outline-primary w-100">See All Notifications</button>
                                        </div>
                                    </div>
                                </li>
                                <li className="nav-item dropdown">
                                    <a className="nav-link pe-0" href="#" id="drop1" aria-expanded="false">
                                        <div className="d-flex align-items-center">
                                            <div className="user-profile-img">
                                                <img src="/assets/images/profile/user-1.jpg" className="rounded-circle" width="35" height="35" alt="modernize-img" />
                                            </div>
                                        </div>
                                    </a>
                                    <div className="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                        <div className="profile-dropdown position-relative" data-simplebar>
                                            <div className="py-3 px-7 pb-0">
                                                <h5 className="mb-0 fs-5 fw-semibold">User Profile</h5>
                                            </div>
                                            <div className="d-flex align-items-center py-9 mx-7 border-bottom">
                                                <img src="/assets/images/profile/user-1.jpg" className="rounded-circle" width="80" height="80" alt="modernize-img" />
                                                <div className="ms-3">
                                                    <h5 className="mb-1 fs-3">{first_name} {last_name}</h5>
                                                    <span className="mb-1 d-block">{professions.professions.map((item, index) => (
                                                        <span key={'profession-' + index}>{ item }</span>
                                                    ))}</span>
                                                    <p className="mb-0 d-flex align-items-center gap-2">
                                                        <i className="ti ti-mail fs-4"></i> <a href="/cdn-cgi/l/email-protection" className="__cf_email__" data-cfemail="b3daddd5dcf3dedcd7d6c1dddac9d69dd0dcde">[email&#160;protected]</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div className="message-body">
                                                <a href="/main/page-user-profile.html" className="py-8 px-7 mt-8 d-flex align-items-center">
                                                    <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                        <img src="/assets/images/svgs/icon-account.svg" alt="modernize-img" width="24" height="24" />
                                                    </span>
                                                    <div className="w-100 ps-3">
                                                        <h6 className="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                                                        <span className="fs-2 d-block text-body-secondary">Account Settings</span>
                                                    </div>
                                                </a>
                                                <a href="/main/app-email.html" className="py-8 px-7 d-flex align-items-center">
                                                    <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                        <img src="/assets/images/svgs/icon-inbox.svg" alt="modernize-img" width="24" height="24" />
                                                    </span>
                                                    <div className="w-100 ps-3">
                                                        <h6 className="mb-1 fs-3 fw-semibold lh-base">My Inbox</h6>
                                                        <span className="fs-2 d-block text-body-secondary">Messages & Emails</span>
                                                    </div>
                                                </a>
                                                <a href="/main/app-notes.html" className="py-8 px-7 d-flex align-items-center">
                                                    <span className="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                        <img src="/assets/images/svgs/icon-tasks.svg" alt="modernize-img" width="24" height="24" />
                                                    </span>
                                                    <div className="w-100 ps-3">
                                                        <h6 className="mb-1 fs-3 fw-semibold lh-base">My Task</h6>
                                                        <span className="fs-2 d-block text-body-secondary">To-do and Daily Tasks</span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div className="d-grid py-4 px-7 pt-8">
                                                <div className="upgrade-plan bg-primary-subtle position-relative overflow-hidden rounded-4 p-4 mb-9">
                                                    <div className="row">
                                                        <div className="col-6">
                                                            <h5 className="fs-4 mb-3 fw-semibold">Unlimited Access</h5>
                                                            <button className="btn btn-primary">Upgrade</button>
                                                        </div>
                                                        <div className="col-6">
                                                            <div className="m-n4 unlimited-img">
                                                                <img src="/assets/images/backgrounds/unlimited-bg.png" alt="modernize-img" className="w-100" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="/main/authentication-login.html" className="btn btn-outline-primary">Log Out</a>
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
    );
}
