import { usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';
import InputError from '@/components/input-error';
import { RadiologyFormProps } from '@/components/radiology/radiology';
import FormHeader from '@/components/ui/form-header';

interface InertiaProps {
    radiologyOptions: Options[];
}

const RadiologyForm = ({ data, setData, errors = {} }: RadiologyFormProps) => {
    const { radiologyOptions } = usePage().props as unknown as InertiaProps;

    const updateRadiologyScan = (e: React.ChangeEvent<HTMLInputElement>) => {};

    return (
        <>
            <div className="form-group">
                <FormHeader>Radiology Request</FormHeader>
                <div className="row">
                    <div className="col-md-4"></div>
                </div>
            </div>
        </>
    );
};

export default RadiologyForm;
