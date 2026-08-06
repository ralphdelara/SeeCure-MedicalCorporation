import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Cashier() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Cashier" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Cashier">
                &nbsp;
            </Breadcrumbs>
        </>
    );
}
