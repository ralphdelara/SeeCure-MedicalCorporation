import { usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';
import InputError from '@/components/input-error';
import { LaboratoryFormProps } from '@/components/laboratory/laboratory';

interface InertiaProps {
    laboratoryOptions: Options[];
}

const LaboratoryForm = ({ data, setData, errors = {} }: LaboratoryFormProps) => {
    const { laboratoryOptions } = usePage().props as unknown as InertiaProps;

    const updateLaboratoryTests = (e: React.ChangeEvent<HTMLInputElement>) => {};

    return (
        <>
            <div className="form-group">
                <Label htmlFor="medicalServices" className="form-label fs-5">
                    Laboratory Form
                </Label>
                <div className="row">
                    <div className="col-md-4"></div>
                </div>
            </div>
        </>
    );
};

export default LaboratoryForm;
