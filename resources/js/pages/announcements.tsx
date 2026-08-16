import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Announcements() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Announcements" />
            <Breadcrumbs title="Announcements">&nbsp;</Breadcrumbs>
        </>
    );
}
