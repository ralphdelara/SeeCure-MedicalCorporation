import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { Button } from '@/components/ui/button';
import { callOut } from '@/routes/system';
import { Input } from '@/components/ui/input';
import { IconDeviceFloppy } from '@tabler/icons-react';
import SaveCompanyProfile from './save-company-profile';
import { formSubmitResponse } from '@/lib/utils';
import { updateCompanyProfile } from '@/actions/App/Http/Controllers/SystemController';
import { Toaster } from 'react-hot-toast';

export default function System() {
    const { companyProfile } = usePage().props as unknown as {
        companyProfile: {
            company_name: string;
            company_reg_no: string;
            non_vat_tin: string;
            min: string;
            sn: string;
            accreditation_no: string;
            accreditation_date_issued: string;
            ptu_no: string;
            ptu_date_issued: string;
            bir_no: string;
            tel_no: string;
            phone_no: string;
            email: string;
            clinic_hours: string;
            address: string;
            landmark: string;
        };
    };
    const { data, setData, isDirty, put } = useForm({
        company_name: companyProfile.company_name ?? '',
        company_reg_no: companyProfile.company_reg_no ?? '',
        non_vat_tin: companyProfile.non_vat_tin ?? '',
        min: companyProfile.min ?? '',
        sn: companyProfile.sn ?? '',
        accreditation_no: companyProfile.accreditation_no ?? '',
        accreditation_date_issued: companyProfile.accreditation_date_issued ?? '',
        ptu_no: companyProfile.ptu_no ?? '',
        ptu_date_issued: companyProfile.ptu_date_issued ?? '',
        bir_no: companyProfile.bir_no ?? '',
        tel_no: companyProfile.tel_no ?? '',
        phone_no: companyProfile.phone_no ?? '',
        email: companyProfile.email ?? '',
        clinic_hours: companyProfile.clinic_hours ?? '',
        address: companyProfile.address ?? '',
        landmark: companyProfile.landmark ?? '',
    });

    const submitCompanyProfile = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(updateCompanyProfile().url, {
            ...formSubmitResponse('Company Profile'),
        });
    };

    return (
        <>
            <Head title="System" />
            <Toaster />
            <Breadcrumbs title="Company Profile">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <form onSubmit={submitCompanyProfile}>
                        <SaveCompanyProfile isDirty={isDirty} className="mb-3" />
                        <div className="row g-3 w-100">
                            <div className="col-md-8">
                                <h5>Clinic Name</h5>
                                <Input
                                    value={data.company_name}
                                    onChange={(e) => setData('company_name', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Clinic Reg No</h5>
                                <Input
                                    value={data.company_reg_no}
                                    onChange={(e) => setData('company_reg_no', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Clinic Hours</h5>
                                <Input
                                    value={data.clinic_hours}
                                    onChange={(e) => setData('clinic_hours', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Address</h5>
                                <Input
                                    value={data.address}
                                    onChange={(e) => setData('address', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Landmark</h5>
                                <Input
                                    value={data.landmark}
                                    onChange={(e) => setData('landmark', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>NON VAT TIN</h5>
                                <Input
                                    value={data.non_vat_tin}
                                    onChange={(e) => setData('non_vat_tin', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>MIN</h5>
                                <Input
                                    value={data.min}
                                    onChange={(e) => setData('min', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>SN</h5>
                                <Input
                                    value={data.sn}
                                    onChange={(e) => setData('sn', e.target.value)}
                                />
                            </div>
                            <div className="col-md-6">
                                <h5>Accreditation No</h5>
                                <Input
                                    value={data.accreditation_no}
                                    onChange={(e) => setData('accreditation_no', e.target.value)}
                                />
                            </div>
                            <div className="col-md-6">
                                <h5>Date Issued</h5>
                                <Input
                                    type="date"
                                    value={data.accreditation_date_issued}
                                    onChange={(e) =>
                                        setData('accreditation_date_issued', e.target.value)
                                    }
                                />
                            </div>
                            <div className="col-md-6">
                                <h5>PTU No</h5>
                                <Input
                                    value={data.ptu_no}
                                    onChange={(e) => setData('ptu_no', e.target.value)}
                                />
                            </div>
                            <div className="col-md-6">
                                <h5>Date Issued</h5>
                                <Input
                                    type="date"
                                    value={data.ptu_date_issued}
                                    onChange={(e) => setData('ptu_date_issued', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Tel No.</h5>
                                <Input
                                    value={data.tel_no}
                                    onChange={(e) => setData('tel_no', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Phone No.</h5>
                                <Input
                                    value={data.phone_no}
                                    onChange={(e) => setData('phone_no', e.target.value)}
                                />
                            </div>
                            <div className="col-md-4">
                                <h5>Email</h5>
                                <Input
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                />
                            </div>
                        </div>
                        <SaveCompanyProfile isDirty={isDirty} className="mt-3" />
                    </form>
                </div>
            </div>
        </>
    );
}
