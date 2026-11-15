import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { IconArrowForward, IconHierarchy, IconSettings, IconShieldCog, IconTelescope, IconUser, IconUserEdit } from '@tabler/icons-react';
import { useEffect, useState } from 'react';
import { getUrlParams } from '@/lib/utils';
import PatientVisitData from './patient-visit-data';
import OutPatientFlow from './outpatient-flow';
import InPatientFlow from './inpatient-flow';
import PurposeAndScope from './purpose-and-scope';
import SystemRequirementsAndSetup from './system-requirements-and-setup';
import RolesAndAccessControl from './roles-and-access-control';
import StandardOperatingProcedures from './standard-operating-procedures';
import Others from './others';

export default function Guide() {
    const breadcrumbs = {};
    const [selectedTab, setSelectedTab] = useState(() => {
        // This reads the parameter immediately on mount before anything else renders
        return getUrlParams('tab', 'tab-purpose-and-scope');
    });
    const [selectedTabName, setSelectedTabName] = useState('Purpose and Scope');
    const tabs = [
        { id: 'tab-purpose-and-scope', name: 'Purpose and Scope', icon: <IconTelescope /> },
        { id: 'tab-system-requirements-and-setup', name: 'System Requirements and Setup', icon: <IconSettings /> },
        { id: 'tab-patient-visit-data', name: 'Patient Visit Data', icon: <IconUser /> },
        { id: 'tab-outpatient-flow', name: 'OutPatient Flow', icon: <IconUserEdit /> },
        { id: 'tab-inpatient-flow', name: 'InPatient Flow', icon: <IconUserEdit /> },
        { id: 'tab-roles-and-access-control', name: 'Roles and Access Control', icon: <IconShieldCog /> },
        { id: 'tab-standard-operating-procedures', name: 'Standard Operating Procedures', icon: <IconArrowForward /> },
        { id: 'tab-others', name: 'Safety Rules, Audit and Troubleshooting', icon: <IconHierarchy /> },
    ];

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
            <Head title="Guidelines" />
            <Breadcrumbs title="Guidelines">&nbsp;</Breadcrumbs>
            <div className="row w-100 mt-2 px-4 fs-5">
                Clinical and operational guidelines are standardized, evidence-based rules and best practices that govern how healthcare staff diagnose,
                treat, and manage patients safely. Within the software system of See Cure Infirmary (See Cure Medical Corporation),
                these guidelines act as built-in guardrails that connect every department to ensure consistent care and regulatory compliance.
            </div>
            <div className="row w-100 p-4">
                <ul
                    className="nav nav-pills user-profile-tab justify-content-center bg-success-subtle rounded-2 rounded-top-0 mb-3"
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

                <div className="col-md-12 html-list-reset text-dark">
                    {selectedTab === 'tab-purpose-and-scope' && <PurposeAndScope />}
                    {selectedTab === 'tab-system-requirements-and-setup' && <SystemRequirementsAndSetup />}
                    {selectedTab === 'tab-patient-visit-data' && <PatientVisitData />}
                    {selectedTab === 'tab-outpatient-flow' && <OutPatientFlow />}
                    {selectedTab === 'tab-inpatient-flow' && <InPatientFlow />}
                    {selectedTab === 'tab-roles-and-access-control' && <RolesAndAccessControl />}
                    {selectedTab === 'tab-standard-operating-procedures' && <StandardOperatingProcedures />}
                    {selectedTab === 'tab-others' && <Others />}
                </div>
            </div>
        </>
    );
}
