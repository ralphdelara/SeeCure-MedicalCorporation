import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function System() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="System" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="System">
                &nbsp;
            </Breadcrumbs>
        </>
    );
}
