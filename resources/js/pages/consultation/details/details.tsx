import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import SignsOrSymptomsForm from '@/components/consultation/signs-or-symptoms-form';
import { Head, useForm } from '@inertiajs/react';
import { IconDeviceFloppy } from '@tabler/icons-react';
import { ConsultationDetailsFormProps } from '../../../components/consultation/consultation';

const Details = ({ showTab }: { showTab: boolean }) => {
    const medicalServices = [
        { name: 'Consultation', id: 'has_consultation', value: 1 },
        { name: 'Laboratory', id: 'has_laboratory', value: 1 },
    ];

    const { data, setData, errors } = useForm<ConsultationDetailsFormProps>({
        guardian_name: '',
        guardian_contact_number: '',
        guardian_email: '',
        has_consultation: 1,
        has_laboratory: 0,
        signs_or_symptoms_id: [],
        doctor_id: '',
    });

    const updateMedicalServices = (e: React.ChangeEvent<HTMLInputElement>) => {
        const checkboxId = e.currentTarget.id as keyof ConsultationDetailsFormProps;
        const isChecked = (e.target as HTMLInputElement).checked;
        setData(checkboxId, isChecked ? 1 : 0);
    };

    return (
        <>
            <Head title="Consultation Details" />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form>
                        <div className="d-flex justify-content-between px-10">
                            <h4>Consultation Details</h4>
                            <div className="mt-2 text-right">
                                <Button size="lg">
                                    <i>
                                        <IconDeviceFloppy className="me-1" />
                                    </i>
                                    Save Details
                                </Button>
                            </div>
                        </div>
                        <div className="row mt-3 w-100">
                            <div className="col-lg-4">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <div className="form-group mt-3">
                                            <Label htmlFor="doctor">
                                                <h5 className="fw-bolder">Doctor</h5>
                                            </Label>
                                            <Select type="Doctor" options={[]}></Select>
                                        </div>
                                        <div className="form-group mt-3">
                                            <Label htmlFor="added-by">
                                                <h5 className="fw-bolder">Added by</h5>
                                            </Label>
                                            <h5 id="added-by">
                                                Ralph De Lara
                                                <p>
                                                    <small>Jul 15, 2026 09:50am</small>
                                                </p>
                                            </h5>
                                        </div>
                                        <div className="form-group mt-3">
                                            <Label htmlFor="last-modified-by">
                                                <h5 className="fw-bolder">Last modified by</h5>
                                            </Label>
                                            <h5 id="last-modified-by">
                                                Ralph De Lara
                                                <p>
                                                    <small>Jul 15, 2026 09:50am</small>
                                                </p>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <div className="form-group">
                                            <Label htmlFor="guardian">
                                                <h5 className="fw-bolder">Guardian</h5>
                                            </Label>
                                        </div>
                                        <div className="form-group">
                                            <Label htmlFor="guardian-name" className="form-label">
                                                Name
                                            </Label>
                                            <Input
                                                value={data.guardian_name}
                                                onChange={(e) =>
                                                    setData('guardian_name', e.target.value)
                                                }
                                                id="guardian-name"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. Joy Cruz"
                                                maxLength={50}
                                            />
                                            <Label
                                                htmlFor="guardian-contact-number"
                                                className="form-label"
                                            >
                                                Contact
                                            </Label>
                                            <Input
                                                value={data.guardian_contact_number}
                                                onChange={(e) =>
                                                    setData(
                                                        'guardian_contact_number',
                                                        e.target.value,
                                                    )
                                                }
                                                id="guardian-contact-number"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. 09xxxxxxxxx"
                                                maxLength={50}
                                            />
                                            <Label htmlFor="guardian-email" className="form-label">
                                                Email
                                            </Label>
                                            <Input
                                                value={data.guardian_email}
                                                onChange={(e) =>
                                                    setData('guardian_email', e.target.value)
                                                }
                                                id="guardian-email"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. xxxxxxxxxxxx@gmail.com"
                                                maxLength={100}
                                            />
                                            <Label
                                                htmlFor="guardian-relationship"
                                                className="form-label"
                                            >
                                                Relationship
                                            </Label>
                                            <Input
                                                value={data.guardian_email}
                                                onChange={(e) =>
                                                    setData('guardian_email', e.target.value)
                                                }
                                                id="guardian-email"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. xxxxxxxxxxxx@gmail.com"
                                                maxLength={100}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <SignsOrSymptomsForm
                                            data={data}
                                            setData={setData}
                                            errors={errors}
                                            checkboxDivSize={6}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
};

export default Details;
