import {
    IconActivity,
    IconEye,
    IconFlask,
    IconHistory,
    IconScan,
    IconStethoscope,
    IconView360,
} from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { Modal } from 'react-bootstrap';
import { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import { getLaboratoryDetails } from '@/actions/App/Http/Controllers/LaboratoryController';
import DOMPurify from 'dompurify';
import VisitDetailsConsultation from './visit-details.consultation';
import VisitDetailsLaboratory from './visit-details-laboratory';
import VisitDetailsRadiology from './visit-details-radiology';

const VisitDetailsModal = ({ visit }) => {
    const [formShow, setFormShow] = useState(false);

    const [selectedTab, setSelectedTab] = useState('tab-consultation');

    const tabs = [
        { id: 'tab-consultation', name: 'Consultation', icon: <IconStethoscope /> },
        { id: 'tab-laboratory', name: 'Laboratory', icon: <IconFlask /> },
        { id: 'tab-radiology', name: 'Radiology', icon: <IconScan /> },
    ];

    return (
        <>
            <Button
                variant="default"
                title="View Visit Details"
                rounded={true}
                onClick={() => setFormShow(true)}
            >
                <i>
                    <IconHistory size={18} />
                </i>
            </Button>
            <Modal show={formShow} size="lg" onHide={() => setFormShow(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Visit Details</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="wizard clearfix px-4" role="application">
                        <ul
                            className="nav nav-pills user-profile-tab justify-content-center bg-success-subtle rounded-2 rounded-top-0 mt-2"
                            id="pills-tab"
                            role="tablist"
                        >
                            {tabs.map((item) => {
                                return (
                                    <li
                                        key={'btn-' + item.id}
                                        className="nav-item"
                                        role="presentation"
                                    >
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
                        {selectedTab === 'tab-consultation' && (
                            <VisitDetailsConsultation consultation={visit.consultation ?? []} />
                        )}
                        {selectedTab === 'tab-laboratory' && (
                            <VisitDetailsLaboratory laboratory={visit.laboratory ?? []} />
                        )}
                        {selectedTab === 'tab-radiology' && <VisitDetailsRadiology visit={visit} />}
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                        Close
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default VisitDetailsModal;
