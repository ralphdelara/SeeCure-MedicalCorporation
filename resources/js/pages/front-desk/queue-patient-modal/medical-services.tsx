import InputError from '@/components/input-error';
import type { QueuePatientDetailsFormProps, QueuePatientFormProps } from './types';
import ConsultationForm from './consultation-form';
import RadiologyForm from './radiology-form';
import FormHeader from '@/components/ui/form-header';

const MedicalServices = ({ data, setData, errors = {} }: QueuePatientFormProps) => {
    const medicalServices = [
        { name: 'Consultation', id: 'has_consultation', value: 1 },
        { name: 'Laboratory', id: 'has_laboratory', value: 1 },
        { name: 'Radiology', id: 'has_radiology', value: 1 },
    ];
    const updateMedicalServices = (e: React.ChangeEvent<HTMLInputElement>) => {
        const checkboxId = e.currentTarget.id as keyof QueuePatientDetailsFormProps;
        const isChecked = (e.target as HTMLInputElement).checked;
        setData(checkboxId, isChecked ? 1 : 0);

        if (checkboxId === 'has_laboratory' && data.laboratory_package_id === '') {
            setData('laboratory_package_id', 3); // 3 - Custom
        }
    };

    return (
        <>
            <FormHeader>Medical Services</FormHeader>
            <div className="row">
                {medicalServices.map((item, index) => (
                    <div className="col-md-6" key={'medicalService-' + index}>
                        <div className="form-check form-check-inline">
                            <input
                                className="form-check-input success"
                                type="checkbox"
                                id={item.id}
                                value={item.value}
                                onChange={(e) => updateMedicalServices(e)}
                                name={item.id}
                                checked={data[item.id as keyof QueuePatientDetailsFormProps] === 1}
                            />
                            <label className="form-check-label" htmlFor={item.id}>
                                <h5 className="fw-semibold">{item.name}</h5>
                            </label>
                        </div>
                    </div>
                ))}
            </div>
            <InputError message={errors.has_consultation} className="mt-2" />

            {data.has_consultation === 1 && (
                <ConsultationForm data={data} setData={setData} errors={errors} />
            )}

            {data.has_radiology === 1 && data.has_consultation === 0 && (
                <RadiologyForm data={data} setData={setData} errors={errors} />
            )}
        </>
    );
};

export default MedicalServices;
