import { getAuditLog } from '@/actions/App/Http/Controllers/UserController';
import { convertSnakeToTitleCase, fetchUrl } from '@/lib/utils';
import { Head, usePage } from '@inertiajs/react';
import { IconRotate, IconStar } from '@tabler/icons-react';
import { Fragment, useEffect, useState } from 'react';
import DOMPurify from 'dompurify';

interface InertiaProps {
    userDetails: {
        id: string;
    };
}

interface LogProps {
    data: string;
    audit_type: {
        name: string;
    };
    created_by: {
        full_name: string;
    };
    created_at: string;
}

const AuditLog = () => {
    const { userDetails } = usePage().props as unknown as InertiaProps;
    const [loading, setLoading] = useState(false);
    const [logs, setLogs] = useState<LogProps[]>([]);

    const loadLogs = async () => {
        setLoading(true);
        const response = await fetchUrl(getAuditLog(userDetails.id).url, 'GET', {});

        setLogs(response);
        setLoading(false);
    };

    useEffect(() => {
        loadLogs();
    }, []);

    return (
        <>
            <div className="tab-content">
                <div className="card mt-3 w-100 pb-5">
                    <div className="card-body">
                        <div className="mb-4">
                            <h4 className="fw-bolder">
                                Audit Log {loading && <IconStar className="animate-rotate" />}
                            </h4>
                            <p className="card-subtitle">
                                Automated, time-stamped record of system and user activities
                            </p>
                        </div>

                        {logs.map((item, index) => {
                            let data: {
                                title: string;
                                fields: {
                                    field: string;
                                    from: string;
                                    to: string;
                                    added: string;
                                    deleted: string;
                                }[];
                            } = JSON.parse(item.data);

                            return (
                                <div
                                    className="row border-bottom border-success p-3"
                                    key={'log-' + index}
                                >
                                    <div className="col-lg-2 fs-5 text-dark">
                                        <b>{item.audit_type.name}</b>
                                    </div>
                                    <div className="col-lg-7 fs-5 text-dark">
                                        <h4 className="fw-semibold mb-3">{data.title}</h4>
                                        <div className="d-flex align-items-center">
                                            <div className="table-responsive ms-3">
                                                <table className="table-custom">
                                                    <tbody>
                                                        {data.fields.map((item2, index2) => (
                                                            <Fragment key={'log-field-' + index2}>
                                                                <tr>
                                                                    <td
                                                                        colSpan={4}
                                                                        className="fw-semibold"
                                                                    >
                                                                        {convertSnakeToTitleCase(
                                                                            item2.field,
                                                                        )}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    {(item2.from ?? '') !== '' && (
                                                                        <>
                                                                            <td className="p-1">
                                                                                From:{' '}
                                                                            </td>
                                                                            <td
                                                                                className="fw-semibold html-list-reset py-1 pe-3"
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: DOMPurify.sanitize(
                                                                                        item2.from,
                                                                                    ),
                                                                                }}
                                                                            ></td>
                                                                        </>
                                                                    )}
                                                                    {(item2.to ?? '') !== '' && (
                                                                        <>
                                                                            <td className="p-1">
                                                                                To:{' '}
                                                                            </td>
                                                                            <td
                                                                                className="fw-semibold html-list-reset py-1 pe-3"
                                                                                dangerouslySetInnerHTML={{
                                                                                    __html: DOMPurify.sanitize(
                                                                                        item2.to,
                                                                                    ),
                                                                                }}
                                                                            ></td>
                                                                        </>
                                                                    )}
                                                                    {(item2.added ?? '') !== '' && (
                                                                        <>
                                                                            <td className="p-1">
                                                                                Added:{' '}
                                                                            </td>
                                                                            <td className="fw-semibold py-1 pe-3">
                                                                                {item2.added}
                                                                            </td>
                                                                        </>
                                                                    )}
                                                                    {(item2.deleted ?? '') !==
                                                                        '' && (
                                                                        <>
                                                                            <td className="p-1">
                                                                                Deleted:{' '}
                                                                            </td>
                                                                            <td className="fw-semibold py-1 pe-3">
                                                                                {item2.deleted}
                                                                            </td>
                                                                        </>
                                                                    )}
                                                                </tr>
                                                            </Fragment>
                                                        ))}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-lg-3">
                                        <div className="timeline-desc fs-5 text-dark mt-n1">
                                            <b>{item.created_by.full_name}</b>
                                            <br />
                                            <small>{item.created_at}</small>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </>
    );
};

export default AuditLog;
