import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function System() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="System" />
            <Breadcrumbs title="System">&nbsp;</Breadcrumbs>
        </>
    );
}
