
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useForm, usePage } from '@inertiajs/react';
import { IconPlus } from '@tabler/icons-react';
import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import { Editor } from '@tinymce/tinymce-react';
import toast, { Toaster } from 'react-hot-toast';
import { updatePrivacyPolicy } from '@/actions/App/Http/Controllers/PrivacyPolicyController';
import { formSubmitResponse } from '@/lib/utils';

interface InertiaProps {
    privacyPolicy: {
        id: number;
        policy: string;
        insertNew: number;
    }
}

const UpdatePrivacyPolicy = () => {
    const { privacyPolicy } = usePage().props as unknown as InertiaProps;

    const [showModal, setShowModal] = useState(false);

    const { data, setData, post, processing } = useForm({
        id: privacyPolicy?.id ?? '',
        policy: privacyPolicy?.policy ?? '',
        insertNew: privacyPolicy ? 0 : 1,
    });


    const submitPrivacyPolicy = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(updatePrivacyPolicy().url, {
            ...formSubmitResponse('Privacy Policy'),
            onSuccess: () => {
                setShowModal(false);
            },
            onError: () => {
                toast.error('Something went wrong.');
            },
        });
    }

    return (
        <>
            <Button onClick={() => setShowModal(true)} hasIcon={true}>
                <IconPlus className="me-1" size={18} />
                Update Privacy Policy
            </Button>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={showModal} size="lg" onHide={() => setShowModal(false)}>
                <form onSubmit={submitPrivacyPolicy}>
                    <Modal.Header closeButton>
                        <Modal.Title>Update Privacy Policy
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="form-group">
                            <Label className="w-100" htmlFor="subjective">
                                <h4 className="fw-bolder">
                                    Privacy Policy
                                    <div className="form-check form-check-inline float-right">
                                        <input
                                            className="form-check-input success"
                                            type="checkbox"
                                            id="insertNew"
                                            value="1"
                                            onChange={(e) => setData('insertNew', data.insertNew === 1 ? 0 : 1)}
                                            checked={data.insertNew === 1}
                                        />
                                        <label className="form-check-label" htmlFor="insertNew">
                                            <h5 className="fw-semibold">Insert as New</h5>
                                        </label>
                                    </div>
                                </h4>
                            </Label>
                            <Editor
                                tinymceScriptSrc="/tinymce/tinymce.min.js"
                                licenseKey="gpl"
                                value={data.policy}
                                onEditorChange={(newText) => setData('policy', newText)}
                                init={{
                                    height: 600,
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
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setShowModal(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            Update Privacy Policy
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default UpdatePrivacyPolicy;
