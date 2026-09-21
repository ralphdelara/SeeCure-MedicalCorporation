import { Head, Link, useForm, usePage } from '@inertiajs/react';
import TableList from '@/components/table';
import { IconDownload, IconEdit, IconPlus, IconTrash } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import DocumentModal from './document-modal';
import { useState } from 'react';
import DeleteButton from '@/components/delete-button';
import {
    deleteDocument,
    downloadDocument,
} from '@/actions/App/Http/Controllers/DocumentController';
import { isImage } from '@/lib/utils';
import ImageView from './image-view';

interface InertiaProps {
    department: string;
    details: {
        id: string;
        visit: {
            patient_id: string;
        };
        documents: {
            id: string;
            document_type_id: number;
            type: { name: string };
            files: {
                file_name: string;
                file_ext: string;
            }[];
            created_by: {
                full_name: string;
            };
            created_at: string;
            last_modified_by: {
                full_name: string;
            };
            updated_at: string;
        }[];
    };
}

const Documents = ({ details, department }: InertiaProps) => {
    const { documents } = details;

    const header = [
        { name: '#', align: 'right' },
        { name: 'Type', align: 'left' },
        { name: 'Data', align: 'left' },
        { name: 'Added By', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
        {
            name: '',
            align: 'right',
        },
    ];

    const defaultData = {
        patient_id: department === 'patient' ? details.id : details.visit.patient_id,
        consultation_id: department === 'consultation' ? details.id : null,
        laboratory_id: department === 'laboratory' ? details.id : null,
        radiology_id: department === 'radiology' ? details.id : null,
        document_id: '',
        document_type_id: '3',
        data: [],
    };
    const [formShow, setFormShow] = useState(false);
    const [modalDetails, setModalDetails] = useState({
        formType: 'Add',
        formData: { ...defaultData },
    });

    const handleOpenNewTab = (href: string) => {
        window.open(href, '_blank');
    };

    return (
        <>
            <Head title="Documents" />
            <div className="tab-content">
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <DocumentModal
                        formShow={formShow}
                        setFormShow={setFormShow}
                        formType={modalDetails.formType}
                        formData={modalDetails.formData}
                    />
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <div className="row w-100">
                                <div className="mt-2 text-right">
                                    <Button size="lg" onClick={() => setFormShow(true)}>
                                        <i>
                                            <IconPlus className="me-1" />
                                        </i>
                                        Add Document
                                    </Button>
                                </div>
                                <div className="col-lg-12">
                                    <h4 className="fw-bolder">Documents</h4>
                                </div>
                                <TableList header={header} hasPage={false}>
                                    {documents.map((item, index) => (
                                        <tr key={'docs-' + index}>
                                            <td>{index + 1}</td>
                                            <td>{item.type.name}</td>
                                            <td>
                                                {item.document_type_id === 3 && (
                                                    <table>
                                                        <tbody>
                                                            {item.files.map((file, fileIndex) => {
                                                                let url = downloadDocument({
                                                                    departmentId: details.id,
                                                                    fileName: file.file_name,
                                                                    department: department,
                                                                }).url;
                                                                return (
                                                                    <tr
                                                                        key={
                                                                            'file-' +
                                                                            index +
                                                                            '-' +
                                                                            fileIndex
                                                                        }
                                                                    >
                                                                        <td>
                                                                            {isImage(
                                                                                file.file_ext,
                                                                            ) && (
                                                                                <ImageView
                                                                                    url={url}
                                                                                />
                                                                            )}
                                                                            {!isImage(
                                                                                file.file_ext,
                                                                            ) && (
                                                                                <Link
                                                                                    href="#"
                                                                                    className="flex items-center"
                                                                                    onClick={(
                                                                                        e,
                                                                                    ) => {
                                                                                        e.preventDefault();
                                                                                        handleOpenNewTab(
                                                                                            url,
                                                                                        );
                                                                                    }}
                                                                                >
                                                                                    {file.file_name}
                                                                                </Link>
                                                                            )}
                                                                        </td>
                                                                    </tr>
                                                                );
                                                            })}
                                                        </tbody>
                                                    </table>
                                                )}
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div>
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.created_by.full_name}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.created_at}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-start">
                                                    <div className="ms-3">
                                                        <h6 className="fs-4 fw-semibold">
                                                            {item.last_modified_by?.full_name ?? ''}
                                                        </h6>
                                                        <h6 className="fs-4 fw-normal">
                                                            {item.updated_at ?? ''}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <DeleteButton
                                                    url={
                                                        deleteDocument({
                                                            documentId: item.id,
                                                            departmentId: details.id,
                                                            department: department,
                                                        }).url
                                                    }
                                                    msg={'document'}
                                                    successUrl={
                                                        window.location.pathname +
                                                        window.location.search
                                                    }
                                                />
                                            </td>
                                        </tr>
                                    ))}
                                    {documents.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan={6}
                                                className="fs-7 text-danger text-center"
                                            >
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

export default Documents;
