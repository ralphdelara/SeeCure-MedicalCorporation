import { Head, Link } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';
import { callOut } from '@/routes/system';

export default function System() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="System" />
            <Breadcrumbs title="System">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row w-100 g-5">
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Call Out Display
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Check Transaction
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Backup Database
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Laboratory Tests
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Radiology Tests
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Suppliers
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Inventory
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link className="btn btn-success btn-lg w-100 fs-6 p-3" href={callOut().url}>
                                Payment Method
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
