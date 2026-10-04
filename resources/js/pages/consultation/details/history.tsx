import VisitHistory from '@/components/visit/visit-history';

const History = ({ showTab }: { showTab: boolean }) => {
    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={4}>
                    <VisitHistory />
                </div>
            </div>
        </>
    );
};

export default History;
