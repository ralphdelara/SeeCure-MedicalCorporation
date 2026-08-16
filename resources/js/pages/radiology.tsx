import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Radiology() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Radiology" />
            <Breadcrumbs title="Radiology">&nbsp;</Breadcrumbs>
        </>
    );
}
