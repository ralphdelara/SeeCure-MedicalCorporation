import { Head } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconDownload, IconEdit, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';

const Laboratory = ({ showTab }: { showTab: boolean }) => {
    const header = [
        { name: '#', width: '5%', align: 'right' },
        { name: 'Type', width: '20%', align: 'left' },
        { name: 'Data', width: '20%', align: 'left' },
        { name: 'Requested By', width: '20%', align: 'left' },
        { name: 'Processed By', width: '20%', align: 'left' },
        {
            name: '',
            width: '15%',
            align: 'right',
        },
    ];

    const tableData = [];

    return (
        <>
            <Head title="Laboratory" />
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
                                        Add Laboratory Request
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Laboratory</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    <tr>
                                        <td className="fs-5 text-right align-top">1</td>
                                        <td className="fs-5 align-top">Urinalysis</td>
                                        <td className="fs-5 align-top">Urine Color: Yellow</td>
                                        <td className="fs-5 align-top">
                                            <b>Dr. Robert Chen, M.D.</b>
                                            <br />
                                            <small>Jul 30, 2020 09:30am</small>
                                        </td>
                                        <td className="fs-5">
                                            <p>
                                                <b>Robert Chen, RMT</b>
                                                <br />
                                                <small>Jul 30, 2020 09:30am</small>
                                            </p>
                                            <p>
                                                <b>Robert Chen, RMT</b>
                                                <br />
                                                <small>Jul 30, 2020 09:30am</small>
                                            </p>
                                        </td>
                                        <td className="text-right align-top">
                                            <Button
                                                rounded={true}
                                                title="Download"
                                                className="me-2"
                                            >
                                                <i>
                                                    <IconDownload />
                                                </i>
                                            </Button>
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
                                            <td colSpan={6} className="text-center">
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

export default Laboratory;
