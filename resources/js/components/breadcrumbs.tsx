import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import React from 'react';

interface InertiaProps {
    breadcrumbs: {
        title: string;
        url: string;
    }[];
}

export function Breadcrumbs({ title, children }: { title: string|React.ReactNode; children: React.ReactNode }) {
    const { breadcrumbs } = usePage().props as unknown as InertiaProps;

    return (
        <div className="card bg-success-subtle position-relative overflow-hidden shadow-none">
            <div className="card-body px-4 py-3">
                <div className="row align-items-center">
                    <div className="col-6">
                        <h4 className="fw-semibold mb-8">{title}</h4>
                        <nav aria-label="breadcrumb">
                            <ol className="breadcrumb">
                                {breadcrumbs.map((item, index) => (
                                    <li className="breadcrumb-item" key={'breadcrumbs-' + index}>
                                        <Link className="text-decoration-none" href={item.url}>
                                            {index + 1 === breadcrumbs.length ? (
                                                <b>{item.title}</b>
                                            ) : (
                                                item.title
                                            )}
                                        </Link>
                                    </li>
                                ))}
                            </ol>
                        </nav>
                    </div>
                    <div className="col-6">
                        <div className="d-flex justify-content-end">{children}</div>
                    </div>
                </div>
            </div>
        </div>
    );
}
