import { Breadcrumbs } from '@/components/breadcrumbs';
import PatientInfo from '@/pages/patient/info';
import Details from './details';
import AuditLog from './audit-log';
import {
    IconCash,
    IconListDetails,
    IconUserCode,
} from '@tabler/icons-react';
import { useEffect, useState } from 'react';
import { Head, usePage } from '@inertiajs/react';
import { PatientDetailsProps } from '@/components/patient/patient-details';
import { getUrlParams } from '@/lib/utils';

interface InertiaProps {
    patientDetails: PatientDetailsProps;
    pharmacyDetails: {
        test_data: {
            tests: {
                id: string;
                test: {
                    id: string;
                };
                remarks: string;
                pharmacy_package_id: string;
                pharmacy_type_id: string;
                fields: {
                    id: string;
                    field_type: string;
                    field: {
                        id: string;
                    }
                    value: string;
                }[];
            }[];
        }[];
    };
}

const PharmacyDetails = () => {
    const [selectedTab, setSelectedTab] = useState(() => {
        // This reads the parameter immediately on mount before anything else renders
        return getUrlParams('tab', 'tab-details');
    });
    const [selectedTabName, setSelectedTabName] = useState('Details');
    const [dataFields, setDataFields] = useState({});
    const tabs = [
        { id: 'tab-details', name: 'Details', icon: <IconListDetails /> },
        { id: 'tab-audit-log', name: 'Audit Log', icon: <IconUserCode /> },
    ];
    const { pharmacyDetails, patientDetails } = usePage().props as unknown as InertiaProps;

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
            <Breadcrumbs title="Pharmacy Details">&nbsp;</Breadcrumbs>
            <PatientInfo patientDetails={patientDetails}>
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
            </PatientInfo>
            <Details
                showTab={selectedTab === 'tab-details'}
            />
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
};

export default PharmacyDetails;
