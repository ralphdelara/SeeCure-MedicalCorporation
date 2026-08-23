import { Head, Link, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import SearchField from '@/components/search-field';
import TableList from '@/components/table';
import type { Pages } from '@/types/pagination';
import type { UserTableList } from '@/components/user/list';
import { deleteUser, getUserDetails } from '@/actions/App/Http/Controllers/UserController';
import { IconMail, IconPhone, IconUserEdit } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import NewUser from './new-user-modal';
import DeleteButton from '@/components/delete-button';
import { parseAddress } from '@/lib/utils';

interface InertiaProps {
    userList: {
        tableData: UserTableList[];
        pageData: Pages;
    };
}

export default function UserList() {
    const selectOption = {
        options: [],
        type: 'All Status',
    };
    const { userList } = usePage().props as unknown as InertiaProps;
    const { tableData, pageData } = userList;
    console.log(userList);
    const header =
        tableData.length !== 0
            ? [
                  { name: '#', width: '5%', align: 'right' },
                  { name: 'User • Gender', className: 'sticky-left', align: 'left' },
                  { name: 'Department', align: 'left' },
                  { name: 'Position', align: 'left' },
                  { name: 'Profession', align: 'left' },
                  { name: 'Specialty', align: 'left' },
                  { name: 'Contact', align: 'left' },
                  { name: 'Status', align: 'left' },
                  { name: 'PRC License No', align: 'right' },
                  { name: 'PTR No', align: 'right' },
                  { name: 'Date Hired', align: 'left' },
                  { name: 'Date Resigned', align: 'left' },
                  { name: 'Date of Birth', align: 'left' },
                  { name: 'Address', align: 'left' },
                  { name: 'Added by', align: 'left' },
                  { name: '', className: 'sticky-right', align: 'right' },
              ]
            : [
                  { name: '#', width: '5%', align: 'right' },
                  { name: 'User • Gender', className: 'sticky-left', align: 'left' },
                  { name: '', className: 'sticky-right', align: 'right' },
              ];

    return (
        <>
            <Head title="User List" />
            <Breadcrumbs title="User List">
                <NewUser />
            </Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100">
                        <div className="col-md-12">
                            <SearchField url={pageData.path} selectOption={selectOption} />
                            <TableList header={header} pageData={pageData}>
                                {tableData.map((item, index) => (
                                    <tr key={'userList-' + item.id}>
                                        <td className="text-right">
                                            <h5>{pageData.from + index}</h5>
                                        </td>
                                        <td className="sticky-left">
                                            <div className="d-block">
                                                <div className="d-flex align-items-center">
                                                    <div style={{ width: '40px' }}>
                                                        <img
                                                            className="rounded-circle"
                                                            width="40"
                                                            height="40"
                                                            src="../assets/images/profile/user-2.jpg"
                                                        />
                                                    </div>
                                                    <div className="ms-3">
                                                        <h6 className="fs-4 fw-semibold mb-0">
                                                            <Link
                                                                href={getUserDetails(item.id)}
                                                                className="tooltip-container"
                                                                data-title="Click to View User Details"
                                                            >
                                                                {item.full_name}
                                                            </Link>
                                                        </h6>
                                                        <span className="fw-normal">
                                                            {item.gender ? item.gender.name : 'N/A'}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{item.department?.name}</td>
                                        <td>{item.position?.name ?? 'N/A'}</td>
                                        <td>
                                            {item.professions?.map((profession) => (
                                                <h6
                                                    key={
                                                        'profession-' +
                                                        profession.profession.id +
                                                        '-' +
                                                        item.id
                                                    }
                                                >
                                                    {profession.profession.name}
                                                </h6>
                                            )) ?? <h6>N/A</h6>}
                                        </td>
                                        <td>
                                            {item.specialties?.map((specialty) => (
                                                <h6
                                                    key={
                                                        'specialty-' + specialty.specialty.id + '-' + item.id
                                                    }
                                                >
                                                    {specialty.specialty.name}
                                                </h6>
                                            )) ?? <h6>N/A</h6>}
                                        </td>
                                        <td>
                                            <div className="d-flex align-items-start">
                                                <div>
                                                    <h6>
                                                        <IconPhone size={20} />
                                                    </h6>
                                                    <span className="fw-normal">
                                                        <IconMail size={20} />
                                                    </span>
                                                </div>
                                                <div className="ms-3">
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.contact_number ?? 'N/A'}
                                                    </h6>
                                                    <h6 className="fs-4 fw-normal">
                                                        {item.email ?? 'N/A'}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {item.status ? (
                                                <span className="badge text-bg-success">
                                                    Active
                                                </span>
                                            ) : (
                                                <span className="badge text-bg-danger">
                                                    InActive
                                                </span>
                                            )}
                                        </td>
                                        <td className="text-right">{item.license_no}</td>
                                        <td className="text-right">{item.ptr_no}</td>
                                        <td>{item.date_hired}</td>
                                        <td>{item.date_resigned}</td>
                                        <td>{item.date_of_birth}</td>
                                        <td>{parseAddress(item) ?? 'N/A'}</td>
                                        <td>
                                            <div className="d-flex align-items-center">
                                                <div style={{ width: '40px' }}>
                                                    <img
                                                        className="rounded-circle"
                                                        width="40"
                                                        height="40"
                                                        src="../assets/images/profile/user-2.jpg"
                                                    />
                                                </div>
                                                <div className="ms-3">
                                                    <h6 className="fs-4 fw-semibold mb-0">
                                                        <Link
                                                            className="tooltip-container"
                                                            data-title="Click to View User Details"
                                                            href={getUserDetails(
                                                                item.created_by?.id ?? '',
                                                            )}
                                                        >
                                                            {item.created_by?.full_name}
                                                        </Link>
                                                    </h6>
                                                    <span className="fw-normal">
                                                        {item.created_at}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="sticky-right">
                                            <Link href={getUserDetails(item.id)}>
                                                <Button
                                                    rounded={true}
                                                    className="me-1"
                                                    title="User Details"
                                                >
                                                    <i>
                                                        <IconUserEdit size={18} />
                                                    </i>
                                                </Button>
                                            </Link>

                                            <DeleteButton
                                                url={deleteUser(item.id).url}
                                                msg={'user <b>' + item.full_name + '</b>.'}
                                            />
                                        </td>
                                    </tr>
                                ))}
                                {tableData.length === 0 && (
                                    <tr>
                                        <td colSpan={3} className="text-danger fs-7 text-center">
                                            No records
                                        </td>
                                    </tr>
                                )}
                            </TableList>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
