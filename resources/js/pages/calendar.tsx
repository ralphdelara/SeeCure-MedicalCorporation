import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Calendar() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Calendar" />
            <Breadcrumbs title="Calendar">&nbsp;</Breadcrumbs>
        </>
    );
}
