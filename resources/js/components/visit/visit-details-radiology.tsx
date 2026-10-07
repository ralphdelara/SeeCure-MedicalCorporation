import { IconEye, IconFlask, IconScan, IconStethoscope } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { getConsultationDetails } from '@/actions/App/Http/Controllers/ConsultationController';
import DOMPurify from 'dompurify';
import { getLaboratoryDetails } from '@/actions/App/Http/Controllers/LaboratoryController';

const VisitDetailsRadiology = ({ visit }) => {
    return (
        <>
            <div className="d-flex justify-content-between">
                <h4 className="fw-bolder">
                    <IconScan /> Radiology (Under maintenace)
                </h4>
                <Button
                    variant="default"
                    title="Open Radiology Details"
                    rounded={true}
                    onClick={() => {}}
                >
                    <i>
                        <IconEye />
                    </i>
                </Button>
            </div>
        </>
    );
};

export default VisitDetailsRadiology;
