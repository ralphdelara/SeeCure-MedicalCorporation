import { Head, useForm, usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';
import { toast, Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import NewPatientForm from '@/components/patient/new-patient-form';
import { AddOrUpdatePatientDetailsFormProps } from '@/components/patient/new-patient';
import { addOrUpdatePatient } from '@/actions/App/Http/Controllers/PatientController';
import { PatientDetailsTabProps } from '@/components/patient/patient-details';

const Details = () => {
    const { patientDetails } = usePage().props as unknown as PatientDetailsTabProps;

    const { data, setData, put, processing, errors, reset } =
        useForm<AddOrUpdatePatientDetailsFormProps>({
            patient_id: patientDetails.id,
            last_name: patientDetails.last_name,
            first_name: patientDetails.first_name,
            middle_name: patientDetails.middle_name ?? '',
            patient_suffix_id: patientDetails.patient_suffix_id ?? '',
            date_of_birth: patientDetails.date_of_birth ?? '',
            age: patientDetails.age ?? '',
            contact_number1: patientDetails.contact_number1 ?? '',
            contact_number2: patientDetails.contact_number2 ?? '',
            email: patientDetails.email ?? '',
            occupation: patientDetails.occupation ?? '',

            gender_id: patientDetails.gender_id ?? '',
            civil_status_id: patientDetails.civil_status_id ?? '',
            nationality_id: patientDetails.nationality_id ?? '',

            house_no: patientDetails.house_no ?? '',
            street: patientDetails.street ?? '',
            barangay_id: patientDetails.barangay_id ?? '',
            city_id: patientDetails.city_id ?? '',
            province_id: patientDetails.province_id ?? 1,

            photo: patientDetails.photo ?? '',

            philhealth_id: patientDetails.philhealth_id ?? '',
        });

    const saveDetails = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(addOrUpdatePatient().url, {
            onSuccess: () => {
                toast.success('Patient has been updated.');
            },
            onError: () => {
                toast.error('Failed to update patient.');
            },
        });
    }

    return (
        <>
            <Head title="Patient Details" />
            <Toaster position="top-center" reverseOrder={false} />
            <div className="tab-content mt-3">
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <div className="card border shadow-none">
                        <div className="card-body">
                            <form onSubmit={saveDetails}>
                                <div className="row w-100">
                                    <div className="mt-2 text-right">
                                        <Button size="lg">
                                            <i>
                                                <IconDeviceFloppy className="me-1" />
                                            </i>
                                            Save Details
                                        </Button>
                                    </div>
                                    <div className="col-lg-12">
                                        <h4 className="fw-bolder">Patient Details</h4>
                                    </div>
                                </div>
                                <div className="row mt-3 w-100">
                                    <NewPatientForm data={data} setData={setData} errors={errors} />
                                </div>
                                <div className="mt-2 text-right">
                                    <Button size="lg">
                                        <i>
                                            <IconDeviceFloppy className="me-1" />
                                        </i>
                                        Save Details
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Details;
