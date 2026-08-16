import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Blank() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="" />
            <Breadcrumbs title="Blank">&nbsp;</Breadcrumbs>
        </>
    );
}
