import { Link, usePage } from '@inertiajs/react';
import {
    IconBed,
    IconBuildingBank,
    IconCashRegister,
    IconChartLine,
    IconCircle,
    IconCircleFilled,
    IconDeviceDesktop,
    IconDots,
    IconFlask,
    IconLockCog,
    IconPill,
    IconPrescription,
    IconScan,
    IconStethoscope,
    IconUser,
    IconUserCog,
    IconX,
} from '@tabler/icons-react';
import { useState } from 'react';
import logoText from '@/assets/images/logos/logo_text.png';
import {
    consultationList,
    dashboard,
    frontDesk,
    laboratoryList,
    patients,
    inventory,
    radiology,
    system,
    users,
    pharmacy,
    billing,
    cashier,
    reports,
    visits,
    admitted,
    admissions,
    discharged,
    transfer,
    wards,
} from '@/routes';
import personDefault from '@/assets/images/profile/person-default.png';
import { departments, profile } from '@/routes/user';
import { getBillingSuppliesList } from '@/actions/App/Http/Controllers/BillingController';

type NavSidebarProps = {
    toggleSidebar: () => void;
};

interface User {
    first_name: string;
    last_name: string;
}

export default function NavSidebar({ toggleSidebar }: NavSidebarProps) {
    const { auth, navCounts } = usePage().props as unknown as {
        auth: { user: User };
        navCounts: {
            visitsCount: number;
            visitsPendingCount: number;
            patientCount: number;
            consultationCount: number;
            consultationPendingTodayCount: number;
            consultationPendingCount: number;
            consultationCompletedCount: number;
            laboratoryCount: number;
            laboratoryPendingTodayCount: number;
            laboratoryPendingCount: number;
            laboratoryCompletedCount: number;
            inventoryCount: number;
            inventoryHiddenCount: number;
            pharmacyCount: number;
            pharmacyPendingTodayCount: number;
            pharmacyPendingCount: number;
            pharmacyCompletedCount: number;
            billingCount: number;
            billingPendingTodayCount: number;
            billingPendingCount: number;
            billingCompletedCount: number;
            billingSuppliesCount: number;
            cashierCount: number;
            cashierPendingTodayCount: number;
            cashierPendingCount: number;
            cashierCompletedCount: number;
            usersCount: number;
        };
    };

    const { first_name, last_name } = auth.user;
    const { url } = usePage();
    const [initSidebarType] = useState<string | null>(
        document.body.getAttribute('data-sidebartype'),
    );

    const routes = [
        {
            url: dashboard(),
            name: 'Dashboard',
            icon: IconChartLine,
            active: url.includes(dashboard().url),
            count: 0,
            childNav: [
                {
                    url: dashboard(),
                    name: 'Overview',
                    active: url === dashboard().url,
                    count: 0,
                },
                {
                    url: reports(),
                    name: 'Reports',
                    active: url === reports().url,
                    count: 0,
                },
            ],
        },
        {
            url: frontDesk(),
            name: 'Front Desk',
            icon: IconDeviceDesktop,
            active: url.includes(frontDesk().url),
            count: navCounts.visitsPendingCount,
            childNav: [
                {
                    url: frontDesk(),
                    name: 'Overview',
                    active: url === frontDesk().url,
                    count: navCounts.visitsPendingCount,
                },
                {
                    url: visits(),
                    name: 'Visits',
                    active: url === visits().url,
                    count: navCounts.visitsCount,
                },
            ],
        },
        {
            url: patients(),
            name: 'Patients',
            icon: IconUser,
            active: url.includes(patients().url.slice(0, -1)),
            count: navCounts.patientCount,
            childNav: [
                {
                    url: patients(),
                    name: 'Listing',
                    active: url === patients().url,
                    count: navCounts.patientCount,
                },
            ],
        },
        {
            url: admissions(),
            name: 'Admissions',
            icon: IconBed,
            active: url.includes(admissions().url.slice(0, -1)),
            count: 0,
            childNav: [
                {
                    url: admissions(),
                    name: 'Listing',
                    active: url === admissions().url,
                    count: 0,
                },
                {
                    url: admitted(),
                    name: 'Admitted',
                    active: url === admitted().url,
                    count: 0,
                },
                {
                    url: discharged(),
                    name: 'Discharged',
                    active: url === discharged().url,
                    count: 0,
                },
                {
                    url: transfer(),
                    name: 'Transfer',
                    active: url === transfer().url,
                    count: 0,
                },
                {
                    url: wards(),
                    name: 'Wards',
                    active: url === wards().url,
                    count: 0,
                },
            ],
        },
        {
            url: consultationList('pending-today'),
            name: 'Consultation',
            icon: IconStethoscope,
            active: url.includes(consultationList().url.slice(0, -1)),
            count: navCounts.consultationCount,
            childNav: [
                {
                    url: consultationList('pending-today'),
                    name: 'Pending (Today)',
                    active: url === consultationList('pending-today').url,
                    count: navCounts.consultationPendingTodayCount,
                },
                {
                    url: consultationList(),
                    name: 'Pending',
                    active: url === consultationList().url,
                    count: navCounts.consultationPendingCount,
                },
                {
                    url: consultationList('completed'),
                    name: 'Completed',
                    active: url === consultationList('completed').url,
                    count: navCounts.consultationCompletedCount,
                },
            ],
        },
        {
            url: laboratoryList('pending-today'),
            name: 'Laboratory',
            icon: IconFlask,
            active: url.includes(laboratoryList().url),
            count: navCounts.laboratoryCount,
            childNav: [
                {
                    url: laboratoryList('pending-today'),
                    name: 'Pending (Today)',
                    active: url === laboratoryList('pending-today').url,
                    count: navCounts.laboratoryPendingTodayCount,
                },
                {
                    url: laboratoryList(),
                    name: 'Pending',
                    active: url === laboratoryList().url,
                    count: navCounts.laboratoryPendingCount,
                },
                {
                    url: laboratoryList('completed'),
                    name: 'Completed',
                    active: url === laboratoryList('completed').url,
                    count: navCounts.laboratoryCompletedCount,
                },
            ],
        },
        {
            url: radiology('pending-today'),
            name: 'Radiology',
            icon: IconScan,
            active: url.includes(radiology().url),
            count: 0,
            childNav: [
                {
                    url: radiology('pending-today'),
                    name: 'Pending (Today)',
                    active: url === radiology('pending-today').url,
                    count: 0,
                },
                {
                    url: radiology(),
                    name: 'Pending',
                    active: url === radiology().url,
                    count: 0,
                },
                {
                    url: radiology('completed'),
                    name: 'Completed',
                    active: url === radiology('completed').url,
                    count: 0,
                },
            ],
        },
        {
            url: inventory(),
            name: 'Inventory',
            icon: IconPill,
            active: url.includes(inventory().url),
            count: navCounts.inventoryCount,
            childNav: [
                {
                    url: inventory(),
                    name: 'Listing',
                    active: url === inventory().url,
                    count: navCounts.inventoryCount,
                },
                {
                    url: inventory('hidden-items'),
                    name: 'Hidden Items',
                    active: url === inventory('hidden-items').url,
                    count: navCounts.inventoryHiddenCount,
                },
                {
                    url: inventory('stock-movements'),
                    name: 'Stock Movements',
                    active: url === inventory('stock-movements').url,
                    count: 0,
                },
                {
                    url: inventory('expiring-soon'),
                    name: 'Expiring Soon',
                    active: url === inventory('expiring-soon').url,
                    count: 0,
                },
            ],
        },
        {
            url: pharmacy('pending-today'),
            name: 'Pharmacy',
            icon: IconPrescription,
            active: url.includes(pharmacy().url),
            count: navCounts.pharmacyCount,
            childNav: [
                {
                    url: pharmacy('pending-today'),
                    name: 'Pending (Today)',
                    active: url === pharmacy('pending-today').url,
                    count: navCounts.pharmacyPendingTodayCount,
                },
                {
                    url: pharmacy(),
                    name: 'Pending',
                    active: url === pharmacy().url,
                    count: navCounts.pharmacyPendingCount,
                },
                {
                    url: pharmacy('completed'),
                    name: 'Completed',
                    active: url === pharmacy('completed').url,
                    count: navCounts.pharmacyCompletedCount,
                },
            ],
        },
        {
            url: billing('pending-today'),
            name: 'Billing',
            icon: IconBuildingBank,
            active: url.includes(billing().url),
            count: navCounts.billingCount,
            childNav: [
                {
                    url: billing('pending-today'),
                    name: 'Pending (Today)',
                    active: url === billing('pending-today').url,
                    count: navCounts.billingPendingTodayCount,
                },
                {
                    url: billing(),
                    name: 'Pending',
                    active: url === billing().url,
                    count: navCounts.billingPendingCount,
                },
                {
                    url: billing('completed'),
                    name: 'Completed',
                    active: url === billing('completed').url,
                    count: navCounts.billingCompletedCount,
                },
                {
                    url: getBillingSuppliesList(),
                    name: 'Supplies',
                    active: url === getBillingSuppliesList().url,
                    count: navCounts.billingSuppliesCount,
                },
            ],
        },
        {
            url: cashier('pending-today'),
            name: 'Cashier',
            icon: IconCashRegister,
            active: url.includes(cashier().url),
            count: navCounts.cashierCount,
            childNav: [
                {
                    url: cashier('pending-today'),
                    name: 'Pending (Today)',
                    active: url === cashier('pending-today').url,
                    count: navCounts.cashierPendingTodayCount,
                },
                {
                    url: cashier(),
                    name: 'Pending',
                    active: url === cashier().url,
                    count: navCounts.cashierPendingCount,
                },
                {
                    url: cashier('completed'),
                    name: 'Completed',
                    active: url === cashier('completed').url,
                    count: navCounts.cashierCompletedCount,
                },
            ],
        },
        {
            url: users(),
            name: 'Users',
            icon: IconUserCog,
            active: url.includes(users().url.slice(0, -1)),
            count: navCounts.usersCount,
            childNav: [
                {
                    url: users(),
                    name: 'Listing',
                    active: url === users().url,
                    count: navCounts.usersCount,
                },
                {
                    url: profile(),
                    name: 'Profile',
                    active: url === profile().url,
                },
                {
                    url: departments(),
                    name: 'Departments',
                    active: url === departments().url,
                },
            ],
        },
        {
            url: system(),
            name: 'System',
            icon: IconLockCog,
            active: url.includes(system().url),
            childNav: [],
        },
    ];

    const clickLink = () => {
        if (initSidebarType === 'mini-sidebar') {
            toggleSidebar();
        }
    };

    return (
        <aside className="left-sidebar with-vertical no-select">
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
                                    className={
                                        'sidebar-link' +
                                        (item.active ? ' active' : '') +
                                        (item.childNav.length > 0 ? ' has-arrow' : '')
                                    }
                                    href={item.url}
                                >
                                    <span>
                                        <item.icon size={21} />
                                    </span>
                                    <span className="hide-menu">{item.name}</span>
                                    {(item.count ?? 0) > 0 && (
                                        <span className="hide-menu fs-2 badge bg-danger position-absolute right-8">
                                            {item.count}
                                        </span>
                                    )}
                                </Link>
                                {item.childNav.length > 0 && (
                                    <ul
                                        aria-expanded="false"
                                        className={
                                            'first-level' + (item.active ? ' in' : ' collapse')
                                        }
                                    >
                                        {item.childNav.map((childItem, childIndex) => (
                                            <li
                                                className="sidebar-item"
                                                key={'child-nav-' + index + '-' + childIndex}
                                            >
                                                <Link
                                                    href={childItem.url}
                                                    className={
                                                        'sidebar-link' +
                                                        (childItem.active ? ' active' : '')
                                                    }
                                                >
                                                    <div className="round-16 d-flex align-items-center justify-content-center">
                                                        {childItem.active ? (
                                                            <IconCircleFilled
                                                                size={10}
                                                                className="ms-10"
                                                            />
                                                        ) : (
                                                            <IconCircle
                                                                size={10}
                                                                className="ms-10"
                                                            />
                                                        )}
                                                    </div>
                                                    <span className="hide-menu">
                                                        {childItem.name}
                                                    </span>
                                                    {(childItem.count ?? 0) > 0 && (
                                                        <span className="hide-menu fs-2 badge bg-danger position-absolute right-8">
                                                            {childItem.count}
                                                        </span>
                                                    )}
                                                </Link>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </li>
                        ))}
                    </ul>
                </nav>
            </div>
            <div className="fixed-profile bg-success-subtle mx-4 mt-3 mb-2 rounded p-3">
                <div className="hstack gap-3">
                    <div className="john-img">
                        <img
                            src={personDefault}
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
