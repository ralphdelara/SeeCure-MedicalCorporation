import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Guide() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Guide" />
            <Breadcrumbs title="Guide">&nbsp;</Breadcrumbs>
        </>
    );
}
