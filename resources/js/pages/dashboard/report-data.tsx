import { Breadcrumbs } from '@/components/breadcrumbs';
import { Head, usePage } from '@inertiajs/react';
import VacantControlNumbers from './vacant-control-numbers';
import DuplicatePatientNames from './duplicate-patient-names';
import EmptyControlNumber from './empty-control-number';
import DuplicateControlNumbers from './duplicate-control-numbers';

export default function Dashboard() {
    const { reportType, data, tableHeader } = usePage().props as unknown as {
        reportType: string;
        data: any[];
        tableHeader: any[];
    };
    console.log(data);

    return (
        <>
            <Head title="Reports" />
            <Breadcrumbs title={'Reports • ' + reportType}>&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    {reportType === 'Vacant Control Numbers' && <VacantControlNumbers />}
                    {reportType === 'Duplicate Patient Names' && <DuplicatePatientNames />}
                    {reportType === 'Empty Control Number' && <EmptyControlNumber />}
                    {reportType === 'Duplicate Control Numbers' && <DuplicateControlNumbers />}
                </div>
            </div>
        </>
    );
}
