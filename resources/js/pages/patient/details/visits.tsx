import VisitHistory from '@/components/visit/visit-history';
import { Head } from '@inertiajs/react';

const Visits = () => {
    return (
        <>
            <Head title="Visits" />
            <div className="tab-content mt-3">
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={2}>
                    <VisitHistory/>
                </div>
            </div>
        </>
    );
};

export default Visits;
