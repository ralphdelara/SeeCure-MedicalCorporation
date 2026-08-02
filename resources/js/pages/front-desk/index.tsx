import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import Consultation from './consultation';
import ConsultationQueue from './consultation-queue';
import Laboratory from './laboratory';
import Cashier from './cashier';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { IconPlus } from '@tabler/icons-react';
import AddPatient from './add-patient';

export default function FrontDesk() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Front Desk" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Front Desk">
                <AddPatient />
            </Breadcrumbs>

            <div className="row">
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
