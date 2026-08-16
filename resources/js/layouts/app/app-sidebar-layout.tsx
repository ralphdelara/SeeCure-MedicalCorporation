import { Link, usePage } from '@inertiajs/react';
import {
    IconCashRegister,
    IconChartLine,
    IconDeviceDesktop,
    IconDots,
    IconFlask,
    IconLockCog,
    IconPrescription,
    IconScan,
    IconStethoscope,
    IconUser,
    IconUserCog,
    IconX,
} from '@tabler/icons-react';
import { useState } from 'react';
import logoText from '@/assets/images/logos/logo_text.png';
import userImg from '@/assets/images/profile/user-1.jpg';
import {
    cashier,
    consultation,
    dashboard,
    frontDesk,
    laboratory,
    patient,
    pharmacy,
    radiology,
    system,
    users,
} from '@/routes';

type NavSidebarProps = {
    toggleSidebar: () => void;
};

interface User {
    first_name: string;
    last_name: string;
}

export default function NavSidebar({ toggleSidebar }: NavSidebarProps) {
    const { auth } = usePage().props as unknown as { auth: { user: User } };
    const { first_name, last_name } = auth.user;
    const { url } = usePage();
    const [initSidebarType] = useState<string | null>(
        document.body.getAttribute('data-sidebartype'),
    );
    console.log(consultation().url, url);

    const routes = [
        {
            url: dashboard(),
            name: 'Dashboard',
            icon: IconChartLine,
            active: url.includes(dashboard().url),
        },
        {
            url: frontDesk(),
            name: 'Front Desk',
            icon: IconDeviceDesktop,
            active: url.includes(frontDesk().url),
        },
        {
            url: patient(),
            name: 'Patient List',
            icon: IconUser,
            active: url.includes(patient().url),
        },
        {
            url: consultation(),
            name: 'Consultation',
            icon: IconStethoscope,
            active: url.includes(consultation().url),
        },
        {
            url: laboratory(),
            name: 'Laboratory',
            icon: IconFlask,
            active: url.includes(laboratory().url),
        },
        {
            url: radiology(),
            name: 'Radiology',
            icon: IconScan,
            active: url.includes(radiology().url),
        },
        {
            url: pharmacy(),
            name: 'Pharmacy',
            icon: IconPrescription,
            active: url.includes(pharmacy().url),
        },
        {
            url: cashier(),
            name: 'Cashier',
            icon: IconCashRegister,
            active: url.includes(cashier().url),
        },
        { url: users(), name: 'Users', icon: IconUserCog, active: url.includes(users().url) },
        { url: system(), name: 'System', icon: IconLockCog, active: url.includes(system().url) },
    ];

    const clickLink = () => {
        if (initSidebarType === 'mini-sidebar') {
            toggleSidebar();
        }
    };

    return (
        <aside className="left-sidebar with-vertical">
            <div>
                <div className="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/main/index.html" className="logo-img overflow-hidden text-nowrap">
                        <img src={logoText} width="180" />
                    </a>
                    <button
                        onClick={() => toggleSidebar()}
                        className="sidebartoggler text-decoration-none fs-5 d-block d-xl-none ms-auto"
                    >
                        <IconX size={18} />
                    </button>
                </div>

                <nav className="sidebar-nav scroll-sidebar" data-simplebar>
                    <ul id="sidebarnav">
                        <li className="nav-small-cap">
                            <IconDots className="nav-small-cap-icon" size={16} />
                            <span className="hide-menu">Modules</span>
                        </li>
                        {routes.map((item, index) => (
                            <li className="sidebar-item" key={'sidebar-' + index}>
                                <Link
                                    onClick={() => clickLink()}
                                    className={'sidebar-link' + (item.active ? ' active' : '')}
                                    href={item.url}
                                >
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
            <div className="fixed-profile bg-success-subtle mx-4 mt-3 mb-2 rounded p-3">
                <div className="hstack gap-3">
                    <div className="john-img">
                        <img
                            src={userImg}
                            className="rounded-circle"
                            width="40"
                            height="40"
                            alt="modernize-img"
                        />
                    </div>
                    <div className="john-title">
                        <h6 className="fs-4 fw-semibold mb-0">{first_name}</h6>
                        <span className="fs-2">{last_name}</span>
                    </div>
                    <button
                        className="text-success ms-auto border-0 bg-transparent"
                        tabIndex={0}
                        type="button"
                        aria-label="logout"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="logout"
                    >
                        <i className="ti ti-power fs-6"></i>
                    </button>
                </div>
            </div>
        </aside>
    );
}
