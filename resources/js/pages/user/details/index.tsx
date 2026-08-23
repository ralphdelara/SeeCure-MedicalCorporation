import { Head, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import UserInfo from '@/pages/user/info';
import { useState } from 'react';
import {
    IconListDetails,
    IconUserCode,
} from '@tabler/icons-react';
import { UserDetailsProps } from '@/components/user/user-details';
import Details from './details';
import AuditLog from './audit-log';

interface InertiaProps {
    userDetails: UserDetailsProps;
}

export default function UserDetails() {
    const [selectedTab, setSelectedTab] = useState('tab-details');
    const tabs = [
        { id: 'tab-details', name: 'Details', icon: <IconListDetails /> },
        { id: 'tab-audit-log', name: 'Audit Log', icon: <IconUserCode /> },
    ];
    const { userDetails } = usePage().props as unknown as InertiaProps;

    return (
        <>
            <Head title="User Details" />
            <Breadcrumbs title="User Details">&nbsp;</Breadcrumbs>
            <UserInfo userDetails={userDetails}>
                <ul
                    className="nav nav-pills user-profile-tab justify-content-center bg-success-subtle rounded-2 rounded-top-0 mt-2"
                    id="pills-tab"
                    role="tablist"
                >
                    {tabs.map((item) => (
                        <li key={'btn-' + item.id} className="nav-item" role="presentation">
                            <button
                                className={
                                    'nav-link hstack rounded-0 gap-2 py-6' +
                                    (item.id === selectedTab ? ' active' : '')
                                }
                                id="pills-profile-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#pills-profile"
                                type="button"
                                role="tab"
                                aria-controls="pills-profile"
                                aria-selected="false"
                                tabIndex={-1}
                                onClick={() => setSelectedTab(item.id)}
                            >
                                {item.icon}
                                <span className="d-none d-md-block">{item.name}</span>
                            </button>
                        </li>
                    ))}
                </ul>
            </UserInfo>
            {selectedTab === 'tab-details' && <Details />}
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
}
