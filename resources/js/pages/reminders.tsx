import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Reminders() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Reminders" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Reminders"/>
        </>
    );
}
