import { useForm, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import { Modal } from 'react-bootstrap';
import { Toaster } from 'react-hot-toast';
import { Button } from '@/components/ui/button';
import type { Options } from '@/types/options';
import { formSubmitResponse } from '@/lib/utils';
import { addOrUpdateDocument } from '@/actions/App/Http/Controllers/DocumentController';
import { Select } from '@/components/ui/select';
import { Label } from '@/components/ui/label';
import DragAndDropUpload from '@/components/drag-and-drop-upload';

interface InertiaProps {
    documentTypeOptions: Options[];
}

interface ModalProps {
    formType: string;
    formData: any;
    formShow: boolean;
    setFormShow: any;
}

const DocumentModal = ({ formShow, setFormShow, formType, formData }: ModalProps) => {
    const { documentTypeOptions } = usePage().props as unknown as InertiaProps;
    const [uploadedFiles, setUploadedFiles] = useState<File[]>([]);

    const { data, setData, post, processing, errors } = useForm(formData);

    const submitDocument = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(addOrUpdateDocument().url, {
            ...formSubmitResponse('Documents'),
            onFinish: () => {
                setFormShow(false);
            },
        });
    };

    useEffect(() => {
        setData(formData);
    }, [formData]);

    useEffect(() => {
        setData('data', uploadedFiles);
    }, [uploadedFiles]);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <Modal show={formShow} onHide={() => setFormShow(false)}>
                <form onSubmit={submitDocument}>
                    <Modal.Header closeButton>
                        <Modal.Title>{formType} Document</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <div className="wizard clearfix px-4" role="application">
                            <div className="form-group">
                                <Label>Document Type</Label>
                                <Select
                                    value={data.document_type_id}
                                    onChange={(e) => setData('document_type_id', e.target.value)}
                                    options={documentTypeOptions}
                                    required={true}
                                />
                            </div>
                            {data.document_type_id === '3' && (
                                <DragAndDropUpload
                                    files={uploadedFiles}
                                    onFilesChange={setUploadedFiles}
                                />
                            )}
                        </div>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="light" type="button" onClick={() => setFormShow(false)}>
                            Close
                        </Button>
                        <Button variant="default" type="submit" disabled={processing}>
                            {formType} Document
                        </Button>
                    </Modal.Footer>
                </form>
            </Modal>
        </>
    );
};

export default DocumentModal;
