import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import Cashier from './cashier';
import Consultation from './consultation';
import Laboratory from './laboratory';
import QueuePatient from './queue-patient-modal';
import Billing from './billing';
import Radiology from './radiology';
import Pharmacy from './pharmacy';
import NotifyFrontDesk from '../notifications/notify-front-desk';
import { useState } from 'react';

export default function FrontDesk() {
    const [queueList, setQueueList] = useState<any>({
        billingList: [],
        consultationList: [],
        laboratoryList: [],
        pharmacyList: [],
        radiologyList: [],
        cashierList: [],
    });

    return (
        <>
            <NotifyFrontDesk setQueueList={setQueueList}/>
            <Head title="Front Desk" />
            <Breadcrumbs title="Front Desk">
                <QueuePatient />
            </Breadcrumbs>

            <div className="row w-100">
                <div className="col-lg-6">
                    <Billing billingList={queueList.billingList} />
                </div>
                <div className="col-lg-6">
                    <Consultation consultationList={queueList.consultationList} />
                </div>
                <div className="col-lg-6">
                    <Laboratory laboratoryList={queueList.laboratoryList} />
                </div>
                <div className="col-lg-6">
                    <Radiology radiologyList={queueList.radiologyList} />
                </div>
                <div className="col-lg-6">
                    <Cashier cashierList={queueList.cashierList} />
                </div>
                <div className="col-lg-6">
                    <Pharmacy pharmacyList={queueList.pharmacyList} />
                </div>
            </div>
        </>
    );
}
