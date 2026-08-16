import VitalSignsForm from '@/components/vital-signs/vital-signs-form';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { IconDeviceFloppy } from '@tabler/icons-react';

const VitalSigns = ({ showTab }: { showTab: boolean }) => {
    const { data, setData, post } = useForm({
        vital_signs: {},
    });

    return (
        <>
            <Head title="Vital Signs" />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="row w-100">
                    <div className="mt-2 text-right">
                        <Button size="lg">
                            <i>
                                <IconDeviceFloppy className="me-1" />
                            </i>
                            Save Vital Signs
                        </Button>
                    </div>
                    <div className="card mt-3 border shadow-sm">
                        <div className="card-body">
                            <VitalSignsForm data={data} setData={setData} />
                        </div>
                    </div>
                    <div className="mt-2 mb-3 text-right">
                        <Button size="lg">
                            <i>
                                <IconDeviceFloppy className="me-1" />
                            </i>
                            Save Vital Signs
                        </Button>
                    </div>
                </div>
            </div>
        </>
    );
};

export default VitalSigns;
