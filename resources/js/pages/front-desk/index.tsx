import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import Cashier from './cashier';
import Consultation from './consultation';
import Laboratory from './laboratory';
import QueuePatient from './queue-patient-modal';

export default function FrontDesk() {
    return (
        <>
            <Head title="Front Desk" />
            <Breadcrumbs title="Front Desk">
                <QueuePatient />
            </Breadcrumbs>

            <div className="row w-100">
                <div className="col-lg-12">
                    <Consultation />
                </div>
                <div className="col-lg-12">
                    <Laboratory />
                </div>
                <div className="col-lg-12">
                    <Cashier />
                </div>
            </div>
        </>
    );
}
