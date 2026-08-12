import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function PatientList() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Patient Details" />
            <Breadcrumbs title="Patient Details">&nbsp;</Breadcrumbs>
        </>
    );
}
