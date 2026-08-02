import { Link } from '@inertiajs/react';
import React from 'react';

export function Breadcrumbs({
    breadcrumbs,
    title,
    children,
}: {
    breadcrumbs: object | null;
    title: string;
    children: React.ReactNode;
}) {
    return (
        <div className="card bg-success-subtle shadow-none position-relative overflow-hidden mb-4">
            <div className="card-body px-4 py-3">
                <div className="row align-items-center">
                    <div className="col-6">
                        <h4 className="fw-semibold mb-8">{title}</h4>
                        <nav aria-label="breadcrumb">
                            <ol className="breadcrumb">
                                <li className="breadcrumb-item">
                                    <a className="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                </li>
                                <li className="breadcrumb-item" aria-current="page">{title}</li>
                            </ol>
                        </nav>
                    </div>
                    <div className="col-6">
                        <div className="d-flex justify-content-end">
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
