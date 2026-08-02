import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Pharmacy() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Pharmacy" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Pharmacy"/>
        </>
    );
}
