import { Breadcrumbs } from '@/components/breadcrumbs';
import PatientInfo from '@/pages/patient/info';
import {
    IconActivity,
    IconFiles,
    IconFlask,
    IconListCheck,
    IconListDetails,
    IconPrescription,
    IconScan,
    IconStethoscope,
    IconUserCode,
} from '@tabler/icons-react';
import { useEffect, useState } from 'react';
import SOAP from './soap';
import Details from './details';
import Diagnosis from './diagnosis';
import Prescription from './prescription';
import AuditLog from './audit-log';
import Documents from './documents';
import VitalSigns from './vital-signs';
import Radiology from './radiology';
import Laboratory from './laboratory';
import { Head, usePage } from '@inertiajs/react';
import { PatientDetailsProps } from '@/components/patient/patient-details';
import Notification from '../notification';
import { getUrlParams } from '@/lib/utils';

interface InertiaProps {
    patientDetails: PatientDetailsProps;
}

const ConsultationDetails = () => {
    const [selectedTab, setSelectedTab] = useState(() => {
        // This reads the parameter immediately on mount before anything else renders
        return getUrlParams('tab', 'tab-details');
    });
    const [selectedTabName, setSelectedTabName] = useState('Details');
    const tabs = [
        { id: 'tab-details', name: 'Details', icon: <IconListDetails /> },
        { id: 'tab-soap', name: 'S O A P', icon: <IconListCheck /> },
        { id: 'tab-diagnosis', name: 'Diagnosis', icon: <IconStethoscope /> },
        { id: 'tab-prescription', name: 'Prescription', icon: <IconPrescription /> },
        { id: 'tab-laboratory', name: 'Laboratory', icon: <IconFlask /> },
        { id: 'tab-radiology', name: 'Radiology', icon: <IconScan /> },
        { id: 'tab-vital-signs', name: 'Vital Signs', icon: <IconActivity /> },
        { id: 'tab-documents', name: 'Documents', icon: <IconFiles /> },
        { id: 'tab-audit-log', name: 'Audit Log', icon: <IconUserCode /> },
    ];
    const { patientDetails } = usePage().props as unknown as InertiaProps;

    useEffect(() => {
        const initTab = getUrlParams('tab', 'tab-details');
        setSelectedTab(initTab);
    }, []);

    useEffect(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', selectedTab);

        // Updates the browser URL bar without triggering a page reload or router request
        window.history.pushState({}, '', url);
    }, [selectedTab]);

    return (
        <>
            <Head title={selectedTabName} />
            <Breadcrumbs title="Consultation Details">&nbsp;</Breadcrumbs>
            <Notification />
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
            <Details showTab={selectedTab === 'tab-details'} />
            <SOAP showTab={selectedTab === 'tab-soap'} />
            <Diagnosis showTab={selectedTab === 'tab-diagnosis'} />
            <Prescription showTab={selectedTab === 'tab-prescription'} />
            <Laboratory showTab={selectedTab === 'tab-laboratory'} />
            <Radiology showTab={selectedTab === 'tab-radiology'} />
            <VitalSigns showTab={selectedTab === 'tab-vital-signs'} />
            {selectedTab === 'tab-documents' && <Documents />}
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
};

export default ConsultationDetails;
