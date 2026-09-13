import { Head, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import PatientInfo from '@/pages/patient/info';
import { useState } from 'react';
import {
    IconCalendarUser,
    IconFiles,
    IconListDetails,
    IconUserCode,
} from '@tabler/icons-react';
import { PatientDetailsProps } from '@/components/patient/patient-details';
import Details from './details';
import Documents from './documents';
import AuditLog from './audit-log';
import Visits from './visits';

interface InertiaProps {
    patientDetails: PatientDetailsProps;
}

export default function PatientDetails() {
    const [selectedTab, setSelectedTab] = useState('tab-details');
    const tabs = [
        { id: 'tab-details', name: 'Details', icon: <IconListDetails /> },
        { id: 'tab-visits', name: 'Visits', icon: <IconCalendarUser /> },
        { id: 'tab-documents', name: 'Documents', icon: <IconFiles /> },
        { id: 'tab-audit-log', name: 'Audit Log', icon: <IconUserCode /> },
    ];
    const { patientDetails } = usePage().props as unknown as InertiaProps;

    return (
        <>
            <Head title="Patient Details" />
            <Breadcrumbs title="Patient Details">&nbsp;</Breadcrumbs>
            <PatientInfo patientDetails={patientDetails}>
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
            </PatientInfo>
            {selectedTab === 'tab-details' && <Details />}
            {selectedTab === 'tab-visits' && <Visits />}
            {selectedTab === 'tab-documents' && <Documents />}
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
}
