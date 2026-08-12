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
import { useState } from 'react';
import SOAP from './soap';
import Details from './details';
import Diagnosis from './diagnosis';
import Prescription from './prescription';
import AuditLog from './audit-log';
import Documents from './documents';
import VitalSigns from './vital-signs';
import Radiology from './radiology';
import Laboratory from './laboratory';

const ConsultationDetails = () => {
    const [selectedTab, setSelectedTab] = useState('tab-details');
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
    return (
        <>
            <Breadcrumbs title="Consultation Details">&nbsp;</Breadcrumbs>
            <PatientInfo>
                <ul
                    className="nav nav-pills user-profile-tab justify-content-end bg-success-subtle rounded-2 rounded-top-0 mt-2"
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
            {selectedTab === 'tab-soap' && <SOAP />}
            {selectedTab === 'tab-diagnosis' && <Diagnosis />}
            {selectedTab === 'tab-prescription' && <Prescription />}
            {selectedTab === 'tab-laboratory' && <Laboratory />}
            {selectedTab === 'tab-radiology' && <Radiology />}
            {selectedTab === 'tab-vital-signs' && <VitalSigns />}
            {selectedTab === 'tab-documents' && <Documents />}
            {selectedTab === 'tab-audit-log' && <AuditLog />}
        </>
    );
};

export default ConsultationDetails;
