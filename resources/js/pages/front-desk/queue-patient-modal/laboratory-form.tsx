import { usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';
import InputError from '@/components/input-error';
import { AddOrUpdateLaboratoryFormProps } from '@/components/laboratory/new-laboratory';
import NewLaboratoryForm from '@/components/laboratory/new-laboratory-form';

interface InertiaProps {
    laboratoryFormOptions: Options[];
}

const LaboratoryForm = ({ data, setData, errors = {} }: AddOrUpdateLaboratoryFormProps) => {
    const { laboratoryFormOptions } = usePage().props as unknown as InertiaProps;

    const updateLaboratoryTests = (e: React.ChangeEvent<HTMLInputElement>) => {};

    return (
        <>
            <div className="form-group border-bottom border-success mt-3">
                <Label htmlFor="medicalServices" className="form-label fs-5">
                    Laboratory Request
                </Label>
                <NewLaboratoryForm data={data} setData={setData}/>
            </div>
        </>
    );
};

export default LaboratoryForm;
