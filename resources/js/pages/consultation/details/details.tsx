import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select } from '@/components/ui/select';
import SignsOrSymptomsForm from '@/components/consultation/signs-or-symptoms-form';
import { useForm, usePage } from '@inertiajs/react';
import { Options } from '@/types/options';
import { formSubmitResponse, getIdsFromArrayData } from '@/lib/utils';
import SaveButton from './save-button';
import React from 'react';
import { updateDetails } from '@/actions/App/Http/Controllers/ConsultationController';

interface InertiaProps {
    doctors: Options[];
    relationshipOptions: Options[];
    consultationDetails: {
        id: string;
        doctor: {
            id: string;
        };
        guardian_name: string;
        guardian_contact_number: string;
        guardian_email: string;
        guardian_relationship_id: string;
        signs_or_symptoms: number[]
        doctor_id: string;
        created_by: {
            full_name: string;
        };
        last_modified_by: {
            full_name: string;
        };
        created_at: string;
        updated_at: string;
    };
}

const Details = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails, doctors, relationshipOptions } = usePage().props as unknown as InertiaProps;

    const { data, setData, patch, errors, isDirty } = useForm({
        id: consultationDetails.id,
        guardian_name: consultationDetails.guardian_name ?? '',
        guardian_contact_number: consultationDetails.guardian_contact_number ?? '',
        guardian_email: consultationDetails.guardian_email ?? '',
        guardian_relationship_id: consultationDetails.guardian_relationship_id ?? '',
        signs_or_symptoms_id: getIdsFromArrayData(consultationDetails.signs_or_symptoms ?? []),
        doctor_id: consultationDetails.doctor.id,
        consult_reason: consultationDetails.consult_reason,
    });

    const submitDetails = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDetails().url, formSubmitResponse('Details'));
    }

    return (
        <>
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <form onSubmit={submitDetails}>
                        <div className="me-4"><SaveButton type="Details" isDirty={isDirty}/></div>
                        <div className="row mt-3 w-100">
                            <div className="col-lg-4">
                                <div className="card border shadow-sm">
                                    <div className="card-body">
                                        <div className="form-group mt-3">
                                            <Label htmlFor="doctor">
                                                <h5 className="fw-bolder">Doctor</h5>
                                            </Label>
                                            <Select
                                                type="Doctor"
                                                options={doctors}
                                                value={data.doctor_id}
                                                onChange={(e) =>
                                                    setData('doctor_id', e.target.value)
                                                }
                                            ></Select>
                                        </div>
                                        <div className="form-group mt-3">
                                            <Label htmlFor="added-by">
                                                <h5 className="fw-bolder">Added by</h5>
                                            </Label>
                                            <h5 id="added-by">
                                                <span className="fw-semibold">{consultationDetails.created_by.full_name}</span>
                                                <p>
                                                    <small>{consultationDetails.created_at}</small>
                                                </p>
                                            </h5>
                                        </div>
                                        <div className="form-group mt-3">
                                            <Label htmlFor="last-modified-by">
                                                <h5 className="fw-bolder">Last modified by</h5>
                                            </Label>
                                            <h5 id="last-modified-by">
                                                {consultationDetails.last_modified_by?.full_name ?? ''}
                                                <p>
                                                    <small>{consultationDetails.updated_at}</small>
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
                                            <Select
                                                type="Relationship"
                                                options={relationshipOptions}
                                                value={data.guardian_relationship_id}
                                                onChange={(e) =>
                                                    setData(
                                                        'guardian_relationship_id',
                                                        e.target.value,
                                                    )
                                                }
                                            />
                                            <Label htmlFor="consult_reason" className="form-label">
                                                Reason for Consult
                                            </Label>
                                            <Input
                                                value={data.consult_reason}
                                                onChange={(e) =>
                                                    setData('consult_reason', e.target.value)
                                                }
                                                id="consult_reason"
                                                type="text"
                                                className="form-control"
                                                placeholder="ex. Med cert"
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
