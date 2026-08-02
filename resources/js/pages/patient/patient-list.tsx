import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function PatientList() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Patient List"/>
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Patient List"/>
        </>
    );
}
