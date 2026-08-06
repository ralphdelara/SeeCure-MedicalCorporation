import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Radiology() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Radiology" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Radiology">
                &nbsp;
            </Breadcrumbs>
        </>
    );
}
