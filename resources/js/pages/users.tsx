import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';

export default function Users() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="Users" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Users">
                <Button variant="default">Add User</Button>
            </Breadcrumbs>
        </>
    );
}
