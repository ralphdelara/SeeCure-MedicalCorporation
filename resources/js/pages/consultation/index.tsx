import { Head, usePage } from '@inertiajs/react';
import { IconUser } from '@tabler/icons-react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { ConsultationList } from './types';

interface InertiaProps {
    consultationList: {
        tableData: ConsultationList[];
        pageData: Pages;
    };
}

export default function Consultation() {
    const breadcrumbs = {};
    const { consultationList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = consultationList;
    console.log(tableData);
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Patient', width: '25%', align: 'left' },
        { name: 'Signs Or Symptoms', width: '10%', align: 'left' },
        { name: 'Services', width: '10%', align: 'left' },
        { name: 'Doctor', width: '20%', align: 'left' },
        { name: 'Status', width: '10%', align: 'left' },
        { name: 'Created By', width: '10%', align: 'left' },
        { name: '', width: '10%', align: 'right' },
    ];

    const selectOption = {
        options: [],
        type: 'All Status',
    };

    return (
        <>
            <Head title="Consultation" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title="Consultation">
                &nbsp;
            </Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <SearchField url={pageData.path} selectOption={selectOption} />
                    <TableList header={header} pageData={pageData}>
                        {tableData.map((item, index) => (
                            <tr key={'consult-' + index}>
                                <td className="text-right">
                                    <h5>{pageData.from + index}</h5>
                                </td>
                                <td>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div className="round-40 rounded-circle d-flex align-items-center justify-content-center text-bg-info text-white">
                                                        <IconUser />
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6 className="ms-2">
                                                        {item.patient.full_name}
                                                    </h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    {item.signs_or_symptoms.map((item2, index2) => (
                                        <h6 key={'signs-or-symptoms-' + index + '-' + index2}>
                                            {item2.signs_or_symptom.name}
                                        </h6>
                                    ))}
                                </td>
                                <td>
                                    {item.types.map((item2, index2) => (
                                        <h6 key={'type-' + index + '-' + index2}>
                                            {item2.type.name}
                                        </h6>
                                    ))}
                                </td>
                                <td>{item.doctor.full_name}</td>
                                <td>{item.status}</td>
                                <td>{item.created_by.full_name}</td>
                                <td></td>
                            </tr>
                        ))}
                        {tableData.length === 0 && (
                            <tr>
                                <td colSpan={9} className="text-center">
                                    No records
                                </td>
                            </tr>
                        )}
                    </TableList>
                </div>
            </div>
        </>
    );
}
