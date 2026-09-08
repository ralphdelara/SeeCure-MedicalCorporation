import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import Cashier from './cashier';
import Consultation from './consultation';
import Laboratory from './laboratory';
import QueuePatient from './queue-patient-modal';
import Billing from './billing';
import Radiology from './radiology';
import Pharmacy from './pharmacy';

export default function FrontDesk() {
    return (
        <>
            <Head title="Front Desk" />
            <Breadcrumbs title="Front Desk">
                <QueuePatient />
            </Breadcrumbs>

            <div className="row w-100">
                <div className="col-lg-6">
                    <Billing />
                </div>
                <div className="col-lg-6">
                    <Consultation />
                </div>
                <div className="col-lg-6">
                    <Laboratory />
                </div>
                <div className="col-lg-6">
                    <Radiology />
                </div>
                <div className="col-lg-6">
                    <Cashier />
                </div>
                <div className="col-lg-6">
                    <Pharmacy />
                </div>
            </div>
        </>
    );
}
