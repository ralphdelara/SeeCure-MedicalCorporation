import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Consultation() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Consultation" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Consultation"/>
        </>
    );
}
