import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Billing() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Billing" />
            <Breadcrumbs title="Billing">&nbsp;</Breadcrumbs>
        </>
    );
}
