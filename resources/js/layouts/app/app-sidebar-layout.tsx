import logoText from '@/assets/images/logos/logo_text.png'
import { Link, usePage } from '@inertiajs/react';
import { cashier, consultationList, dashboard, frontDesk, laboratory, patientList, pharmacy, radiology, system, users } from '@/routes';
import { IconCashRegister, IconChartLine, IconDeviceDesktop, IconDots, IconFlask, IconLockCog, IconPrescription, IconScan, IconStethoscope, IconUser, IconUserCog, IconX } from '@tabler/icons-react';
import userImg from '@/assets/images/profile/user-1.jpg';
import { useState } from 'react';

type NavSidebarProps = {
    toggleSidebar: () => void;
}

interface User {
    first_name: string;
    last_name: string;
}

export default function NavSidebar({ toggleSidebar }: NavSidebarProps) {
    const { auth } = usePage().props as unknown as { auth: { user: User } };
    const { first_name, last_name } = auth.user;
    const { url } = usePage();
    const [initSidebarType, setInitSidebarType] = useState(document.body.getAttribute('data-sidebartype'));

    const routes = [
        { url: dashboard(), name: 'Dashboard', icon: IconChartLine, active: dashboard().url === url },
        { url: frontDesk(), name: 'Front Desk', icon: IconDeviceDesktop, active: frontDesk().url === url },
        { url: patientList(), name: 'Patient List', icon: IconUser, active: patientList().url === url },
        { url: consultationList(), name: 'Consultation', icon: IconStethoscope, active: consultationList().url === url },
        { url: laboratory(), name: 'Laboratory', icon: IconFlask, active: laboratory().url === url },
        { url: radiology(), name: 'Radiology', icon: IconScan, active: radiology().url === url },
        { url: pharmacy(), name: 'Pharmacy', icon: IconPrescription, active: pharmacy().url === url },
        { url: cashier(), name: 'Cashier', icon: IconCashRegister, active: cashier().url === url },
        { url: users(), name: 'Users', icon: IconUserCog, active: users().url === url },
        { url: system(), name: 'System', icon: IconLockCog, active: system().url === url },
    ];

    const clickLink = () => {
        if (initSidebarType === 'mini-sidebar') {
            toggleSidebar();
        }
    }

    return (
        <aside className="left-sidebar with-vertical">
            <div>
                <div className="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/main/index.html" className="text-nowrap logo-img overflow-hidden">
                        <img src={logoText} width="180" />
                    </a>
                    <button onClick={() => toggleSidebar()} className="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                        <IconX size={18}/>
                    </button>
                </div>

                <nav className="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        <li className="nav-small-cap">
                            <IconDots className="nav-small-cap-icon" size={16}/>
                            <span className="hide-menu">Modules</span>
                        </li>
                        {routes.map((item, index) => (
                            <li className="sidebar-item" key={'sidebar-' + index}>
                                <Link onClick={() => clickLink()} className={"sidebar-link" + (item.active ? " active" : "")} href={item.url}>
                                    <span>
                                        <item.icon size={21} />
                                    </span>
                                    <span className="hide-menu">{item.name}</span>
                                </Link>
                            </li>
                        ))}
                    </ul>
                </nav>
            </div>
            <div className="fixed-profile p-3 mx-4 mb-2 bg-success-subtle rounded mt-3">
                <div className="hstack gap-3">
                    <div className="john-img">
                        <img src={userImg} className="rounded-circle" width="40" height="40" alt="modernize-img" />
                    </div>
                    <div className="john-title">
                        <h6 className="mb-0 fs-4 fw-semibold">{first_name}</h6>
                        <span className="fs-2">{last_name}</span>
                    </div>
                    <button className="border-0 bg-transparent text-success ms-auto" tabIndex={0} type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                        <i className="ti ti-power fs-6"></i>
                    </button>
                </div>
            </div>
        </aside>
    );
}
