import { Breadcrumbs } from '@/components/breadcrumbs';
import TableList from '@/components/table';
import { Head, usePage } from '@inertiajs/react';

export default function VacantControlNumbers() {
    const { data, tableHeader } = usePage().props as unknown as {
        data: any[];
        tableHeader: any[];
    };

    return (
        <>
            <TableList header={tableHeader}>
                {data.map((item, index) => (
                    <tr key={'tr-' + index}>
                        <td>{item}</td>
                    </tr>
                ))}
            </TableList>
        </>
    );
}
