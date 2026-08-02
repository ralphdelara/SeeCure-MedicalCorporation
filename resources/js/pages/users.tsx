import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Users() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Users" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Users"/>
        </>
    );
}
