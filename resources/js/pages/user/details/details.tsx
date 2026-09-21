import { Head, useForm, usePage } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';
import { toast, Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import NewUserForm from '@/components/user/new-user-form';
import { AddOrUpdateUserDetailsFormProps } from '@/components/user/new-user';
import { addOrUpdateUser } from '@/actions/App/Http/Controllers/UserController';
import { UserDetailsTabProps } from '@/components/user/user-details';

const Details = () => {
    const { userDetails } = usePage().props as unknown as UserDetailsTabProps;

    const { data, setData, put, processing, errors, reset } =
        useForm<AddOrUpdateUserDetailsFormProps>({
            user_id: userDetails.id,
            username: userDetails.username,
            password: '',
            last_name: userDetails.last_name,
            first_name: userDetails.first_name,
            middle_name: userDetails.middle_name ?? '',
            date_of_birth: userDetails.date_of_birth
                ? new Date(userDetails.date_of_birth).toLocaleDateString('sv-SE')
                : '',
            contact_number: userDetails.contact_number ?? '',
            email: userDetails.email ?? '',

            gender_id: userDetails.gender_id ?? '',

            house_no: userDetails.house_no ?? '',
            street: userDetails.street ?? '',
            barangay_id: userDetails.barangay_id ?? '',
            city_id: userDetails.city_id ?? '',
            province_id: userDetails.province_id ?? 1,

            photo: userDetails.photo ?? '',
            department_ids: userDetails.departments ?? [],
            profession_ids: userDetails.professions ?? [],
            specialty_ids: userDetails.specialties ?? [],
            position_ids: userDetails.positions ?? [],
            license_no: userDetails.license_no ?? '',
            ptr_no: userDetails.ptr_no ?? '',
            date_hired: userDetails.date_hired
                ? new Date(userDetails.date_hired).toLocaleDateString('sv-SE')
                : '',
            date_resigned: userDetails.date_resigned
                ? new Date(userDetails.date_resigned).toLocaleDateString('sv-SE')
                : '',
            status: userDetails.status,
        });

    const saveDetails = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(addOrUpdateUser().url, {
            onSuccess: () => {
                toast.success('User has been updated.');
            },
            onError: () => {
                toast.error('Failed to update user.');
            },
        });
    };

    return (
        <>
            <Head title="User Details" />
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
                                        <h4 className="fw-bolder">User Details</h4>
                                    </div>
                                </div>
                                <div className="row mt-3 w-100">
                                    <NewUserForm data={data} setData={setData} errors={errors} />
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
