import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import Cashier from './cashier';
import Consultation from './consultation';
import ConsultationQueue from './consultation-queue';
import Laboratory from './laboratory';
import QueuePatient from './queue-patient-modal';

export default function FrontDesk() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Front Desk" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Front Desk">
                <QueuePatient />
            </Breadcrumbs>

            <div className="row w-100">
                <div className="col-lg-8">
                    <Consultation />
                </div>
                <div className="col-lg-4">
                    <ConsultationQueue />
                </div>
                <div className="col-lg-8">
                    <Laboratory />
                </div>
                <div className="col-lg-4">
                    <ConsultationQueue />
                </div>
                <div className="col-lg-8">
                    <Cashier />
                </div>
                <div className="col-lg-4">
                    <ConsultationQueue />
                </div>
            </div>
        </>
    );
}
