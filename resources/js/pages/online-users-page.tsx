import { Head } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import OnlineUsers from './sockets/online-users';
import { useState } from 'react';
import TableList from '@/components/table';
import personDefault from '@/assets/images/profile/person-default.png';

export default function OnlineUsersPage() {
    const breadcrumbs = {};
    const [onlineUsers, setOnlineUsers] = useState<{
        id: string;
        full_name: string;
        position: string;
        gender: string;
    }[]>([]);
    const header = [
        { name: '#', align: 'right', width: '5%' },
        { name: 'User', align: 'left' },
        { name: 'Position', align: 'left' },
    ];

    return (
        <>
            <Head title="Online Users" />
            <Breadcrumbs title="Online Users">&nbsp;</Breadcrumbs>
            <OnlineUsers setOnlineUsers={setOnlineUsers} />
            <div className="row w-100 px-4 py-3">
                <div style={{ letterSpacing: '0.05em', position: 'relative' }} className="mt-3">
                    <h5>
                        <span className="text-danger fw-bolder">{onlineUsers.length}</span> online users
                    </h5>
                </div>
                <TableList header={header}>
                    {onlineUsers.map((item, index) => (
                        <tr key={'online-users-page-' + index}>
                            <td>{index + 1}</td>
                            <td>
                                <div className="d-block">
                                    <div className="d-flex align-items-center">
                                        <div style={{width: '40px;'}}>
                                            <img className="rounded-circle" width="40" height="40" src={personDefault}/>
                                        </div>
                                        <div className="ms-3">
                                            <h6 className="fs-4 fw-semibold mb-0">
                                                {item.full_name}
                                            </h6>
                                            <span className="fw-normal">{item.gender}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{item.position}</td>
                        </tr>
                    ))}
                    {onlineUsers.length === 0 && (
                        <tr>
                            <td colSpan={3} className="text-center">
                                <h3>No online users</h3>
                            </td>
                        </tr>
                    )}
                </TableList>
            </div>
        </>
    );
}
