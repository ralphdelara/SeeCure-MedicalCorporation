import { Head } from '@inertiajs/react';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { dashboard } from '@/routes';
import { Breadcrumbs } from '@/components/breadcrumbs';

export default function Blank() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title=""/>
        </>
    );
}