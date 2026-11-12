import { Head, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import InventoryInfo from '@/pages/inventory/info';
import { useEffect, useState } from 'react';
import { IconListDetails, IconUserCode } from '@tabler/icons-react';
import { InventoryDetailsProps } from '@/components/inventory/inventory-details';
import Details from './details';
import AuditLog from './audit-log';
import { getUrlParams } from '@/lib/utils';
import StockMovement from './stock-movement';

interface InertiaProps {
    inventoryDetails: InventoryDetailsProps;
}

export default function InventoryDetails() {
    const [selectedTab, setSelectedTab] = useState(() => {
        // This reads the parameter immediately on mount before anything else renders
        return getUrlParams('tab', 'tab-details');
    });
    const [selectedTabName, setSelectedTabName] = useState('Details');
    const tabs = [
        { id: 'tab-details', name: 'Details', icon: <IconListDetails /> },
        { id: 'tab-stock-movement', name: 'Stock Movement', icon: <IconListDetails /> },
        { id: 'tab-audit-log', name: 'Audit Log', icon: <IconUserCode /> },
    ];
    const { inventoryDetails } = usePage().props as unknown as InertiaProps;

    useEffect(() => {
        const initTab = getUrlParams('tab', 'tab-details');
        setSelectedTab(initTab);
    }, []);

    useEffect(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', selectedTab);

        // Updates the browser URL bar without triggering a page reload or router request
        window.history.replaceState(window.history.state, '', url.toString());
    }, [selectedTab]);

    return (
        <>
            <Head title={selectedTabName} />
            <Breadcrumbs title="Inventory Details">&nbsp;</Breadcrumbs>
            <InventoryInfo inventoryDetails={inventoryDetails}>
                <ul
                    className="nav nav-pills user-profile-tab justify-content-center bg-success-subtle rounded-2 rounded-top-0 mt-2"
                    id="pills-tab"
                    role="tablist"
                >
                    {tabs.map((item) => {
                        if (item.id === selectedTab) {
                            setSelectedTabName(item.name);
                        }
                        return (
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
                        );
                    })}
                </ul>
            </InventoryInfo>
            <Details showTab={selectedTab === 'tab-details'}/>
            <StockMovement showTab={selectedTab === 'tab-stock-movement'}/>
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
}
