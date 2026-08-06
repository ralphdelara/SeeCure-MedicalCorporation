import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Laboratory() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Laboratory" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Laboratory">
                &nbsp;
            </Breadcrumbs>
        </>
    );
}
