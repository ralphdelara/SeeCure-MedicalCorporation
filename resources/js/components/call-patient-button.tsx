import { callOutPatient } from '@/actions/App/Http/Controllers/SystemController';
import { fetchUrl } from '@/lib/utils';
import { usePage } from '@inertiajs/react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { IconVolume, IconVolumeOff } from '@tabler/icons-react';

const CallPatientButton = ({
    totalCount,
    patientName,
    upNext,
    department,
}: {
    totalCount: number;
    patientName: string;
    upNext: string;
    department: string;
}) => {
    const [allowCallPatient, setAllowCallPatient] = useState(true);

    const callPatient = async () => {
        if (!allowCallPatient) return;

        // Lock the button immediately BEFORE the network request starts
        setAllowCallPatient(false);

        try {
            const response = await fetchUrl(callOutPatient().url, 'POST', {
                patientName: patientName,
                department: department,
                upNext: upNext,
                departmentCount: totalCount,
            });

            // Handle your response here if needed
        } catch (error) {
            console.error('Failed to call patient:', error);
            setAllowCallPatient(true);
        } finally {
            const timer = setTimeout(() => {
                setAllowCallPatient(true);
            }, 10000);
        }
    };
    return (
        <Button
            rounded={true}
            className="me-1"
            title={allowCallPatient ? 'Call Patient' : 'Please wait...'}
            disabled={!allowCallPatient}
            onClick={() => callPatient()}
        >
            <i>
                {allowCallPatient && <IconVolume size={18} />}
                {!allowCallPatient && <IconVolumeOff size={18} />}
            </i>
        </Button>
    );
};

export default CallPatientButton;
