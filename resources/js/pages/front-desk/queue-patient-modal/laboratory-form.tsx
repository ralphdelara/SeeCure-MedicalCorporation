import { usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Options } from '@/types/options';
import InputError from '@/components/input-error';
import { AddOrUpdateLaboratoryFormProps } from '@/components/laboratory/new-laboratory';
import NewLaboratoryForm from '@/components/laboratory/new-laboratory-form';
import FormHeader from '@/components/ui/form-header';

interface InertiaProps {
    laboratoryFormOptions: Options[];
}

const LaboratoryForm = ({ data, setData, errors = {} }: AddOrUpdateLaboratoryFormProps) => {
    const { laboratoryFormOptions } = usePage().props as unknown as InertiaProps;

    const updateLaboratoryTests = (e: React.ChangeEvent<HTMLInputElement>) => {};

    return (
        <>
            <div className="form-group">
                <FormHeader>Laboratory Request</FormHeader>
                <NewLaboratoryForm data={data} setData={setData} />
            </div>
        </>
    );
};

export default LaboratoryForm;
