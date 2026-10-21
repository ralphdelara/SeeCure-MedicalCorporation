import { Head, Link } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';
import { callOut, companyProfile } from '@/routes/system';

export default function System() {
    const breadcrumbs = {};

    return (
        <>
            <Head title="System" />
            <Breadcrumbs title="System">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <div className="row g-5 w-100">
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={callOut().url}
                            >
                                Call Out Display
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={callOut().url}
                            >
                                Call Out Ads
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={companyProfile().url}
                            >
                                Company Profile
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={callOut().url}
                            >
                                Backup Database
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={callOut().url}
                            >
                                Inventory Categories
                            </Link>
                        </div>
                        <div className="col-md-3 text-center">
                            <Link
                                className="btn btn-success btn-lg fs-6 w-100 p-3"
                                href={callOut().url}
                            >
                                Hospital/Clinic
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
