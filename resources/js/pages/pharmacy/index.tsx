import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Pharmacy() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Pharmacy" />
            <Breadcrumbs title="Pharmacy">&nbsp;</Breadcrumbs>
        </>
    );
}
