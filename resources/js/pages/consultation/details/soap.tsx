import { Head, useForm, usePage } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Editor } from '@tinymce/tinymce-react';
import { IconDeviceFloppy } from '@tabler/icons-react';

const SOAP = ({ showTab }: { showTab: boolean }) => {
    const { data, setData } = useForm({
        subjective: '',
        assessment: '',
        plan: '',
    });
    return (
        <>
            <Head title="Subjective Objective Assessment Plan" />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={2}>
                    <div className="row w-100">
                        <div className="col-lg-12">
                            <div className="card border shadow-sm">
                                <div className="card-body">
                                    <form>
                                        <div className="mt-2 text-right">
                                            <div className="mt-2 text-right">
                                                <Button size="lg">
                                                    <i>
                                                        <IconDeviceFloppy className="me-1" />
                                                    </i>
                                                    Save S O A P
                                                </Button>
                                            </div>
                                        </div>
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
                                        <div className="mt-2 text-right">
                                            <Button size="lg">
                                                <i>
                                                    <IconDeviceFloppy className="me-1" />
                                                </i>
                                                Save S O A P
                                            </Button>
                                        </div>
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
