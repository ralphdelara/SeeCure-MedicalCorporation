import { Head } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconEdit, IconFilePlus, IconPencilPlus, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';

const Prescription = ({ showTab }: { showTab: boolean }) => {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Medicine', width: '30%', align: 'left' },
        { name: 'Dosage', width: '40%', align: 'left' },
        { name: 'Quantity', width: '10%', align: 'right' },
        {
            name: '',
            width: '15%',
            align: 'right',
        },
    ];

    const tableData = [];

    return (
        <>
            <Head title="Prescription" />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row w-100">
                                <div className="mt-2 text-right">
                                    <Button size="lg">
                                        <i>
                                            <IconPlus className="me-1" />
                                        </i>
                                        Add Prescription
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Prescription</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    <tr className="fs-5">
                                        <td className="text-right align-top">1</td>
                                        <td className="align-top">Acithromycin</td>
                                        <td className="align-top">Take 1 tablet every day</td>
                                        <td className="text-right align-top">5</td>
                                        <td className="text-right align-top">
                                            <Button rounded={true} title="Edit" className="me-2">
                                                <i>
                                                    <IconEdit />
                                                </i>
                                            </Button>
                                            <Button variant="danger" rounded={true} title="Delete">
                                                <i>
                                                    <IconTrash />
                                                </i>
                                            </Button>
                                        </td>
                                    </tr>
                                    {tableData.length === 0 && (
                                        <tr>
                                            <td colSpan={4} className="text-center">
                                                No record
                                            </td>
                                        </tr>
                                    )}
                                </TableList>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Prescription;
