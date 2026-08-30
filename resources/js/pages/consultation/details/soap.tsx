import { Head, useForm, usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Editor } from '@tinymce/tinymce-react';
import { updateSoap } from '@/actions/App/Http/Controllers/ConsultationController';
import { Toaster } from 'react-hot-toast';
import SaveButton from './save-button';
import { formSubmitResponse } from '@/lib/utils';

interface InertiaProps {
    consultationDetails: {
        id: string;
        soap: {
            id: string;
            subjective: string;
            assessment: string;
            plan: string;
        };
    };
}

const SOAP = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails } = usePage().props as unknown as InertiaProps;
    const { soap } = consultationDetails;

    const { data, setData, patch, isDirty } = useForm({
        id: soap?.id ?? '',
        subjective: soap?.subjective ?? '',
        assessment: soap?.assessment ?? '',
        plan: soap?.plan ?? '',
    });

    const submitSoap = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateSoap().url, formSubmitResponse('S O A P'));
    }

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={2}>
                    <div className="row w-100">
                        <div className="col-lg-12">
                            <div className="card border shadow-sm">
                                <div className="card-body">
                                    <form onSubmit={submitSoap}>
                                        <SaveButton type="S O A P" isDirty={isDirty}/>
                                        <div className="form-group">
                                            <Label htmlFor="subjective">
                                                <h4 className="fw-bolder">
                                                    Subjective / Objective
                                                </h4>
                                            </Label>
                                            <Editor
                                                value={data.subjective}
                                                onEditorChange={(newText) =>
                                                    setData('subjective', newText)
                                                }

                                                // Required for open-source self-hosting
                                                licenseKey="gpl"

                                                init={{
                                                    height: 400,
                                                    menubar: false,

                                                    // Point to the local static assets in your public folder
                                                    base_url: '/tinymce',
                                                    suffix: '.min',

                                                    // Configure local plugins and toolbars
                                                    plugins:
                                                        'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                                                    toolbar:
                                                        'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                }}
                                            />
                                        </div>
                                        <div className="form-group">
                                            <Label htmlFor="assessment">
                                                <h4 className="fw-bolder">Assessment</h4>
                                            </Label>
                                            <Editor
                                                value={data.assessment}
                                                onEditorChange={(newText) =>
                                                    setData('assessment', newText)
                                                }

                                                // Required for open-source self-hosting
                                                licenseKey="gpl"

                                                init={{
                                                    height: 400,
                                                    menubar: false,

                                                    // Point to the local static assets in your public folder
                                                    base_url: '/tinymce',
                                                    suffix: '.min',

                                                    // Configure local plugins and toolbars
                                                    plugins:
                                                        'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                                                    toolbar:
                                                        'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                }}
                                            />
                                        </div>
                                        <div className="form-group">
                                            <Label htmlFor="plan">
                                                <h4 className="fw-bolder">Plan</h4>
                                            </Label>

                                            <Editor
                                                value={data.plan}
                                                onEditorChange={(newText) =>
                                                    setData('plan', newText)
                                                }

                                                // Required for open-source self-hosting
                                                licenseKey="gpl"

                                                init={{
                                                    height: 400,
                                                    menubar: false,

                                                    // Point to the local static assets in your public folder
                                                    base_url: '/tinymce',
                                                    suffix: '.min',

                                                    // Configure local plugins and toolbars
                                                    plugins:
                                                        'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                                                    toolbar:
                                                        'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                }}
                                            />
                                        </div>
                                        <SaveButton type="S O A P" isDirty={isDirty}/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default SOAP;
