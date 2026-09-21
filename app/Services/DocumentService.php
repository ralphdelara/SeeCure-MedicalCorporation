<?php

namespace App\Services;

use App\Enums\AuditTypeEnum;
use App\Enums\DocumentTypeEnum;
use App\Models\ConsultationAudit;
use App\Models\Document;
use App\Models\DocumentFile;
use App\Models\LaboratoryAudit;
use App\Models\PatientAudit;
use Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class DocumentService
{
    public function addOrUpdateDocument(array $documentDetails): void
    {
        $documentType = DocumentTypeEnum::tryFrom($documentDetails['document_type_id']);

        if (empty($documentType)) {
            abort(404);
        }

        $documentId = $this->saveDocument($documentDetails);

        if ($documentDetails['document_type_id'] === '3') {
            $fields = [];
            $documentFiles = [];
            foreach ($documentDetails['data'] as $file) {
                $fileName = Str::uuid7().'.'.$file->getClientOriginalExtension();
                $filePath = 'documents/'.$fileName;
                $fields[] = ['field' => 'File Path', 'to' => $filePath];
                $fields[] = ['field' => 'File Name', 'to' => $fileName];
                $fields[] = ['field' => 'File Size', 'to' => $file->getSize()];
                $fields[] = ['field' => 'File MIME Type', 'to' => $file->getMimeType()];
                $fields[] = ['field' => 'File EXT', 'to' => $file->getClientOriginalExtension()];
                $documentFiles[] = [
                    'document_id'    => $documentId,
                    'file_path'      => $filePath,
                    'file_name'      => $fileName,
                    'file_size'      => $file->getSize(),
                    'file_mime_type' => $file->getMimeType(),
                    'file_ext'       => $file->getClientOriginalExtension(),
                ];

                $this->saveDocumentFile($file, $filePath);
            }

            // store db data
            DocumentFile::fillAndInsert($documentFiles);

            // create audit logs
            if (! empty($documentDetails['consultation_id'])) {
                $departmentId = $documentDetails['consultation_id'];
                $department = 'consultation';
            } elseif (! empty($documentDetails['laboratory_id'])) {
                $departmentId = $documentDetails['laboratory_id'];
                $department = 'laboratory';
            } elseif (! empty($documentDetails['radiology_id'])) {
                $departmentId = $documentDetails['radiology_id'];
                $department = 'radiology';
            } else {
                $departmentId = $documentDetails['patient_id'];
                $department = 'patient';
            }

            $this->logAudit($departmentId, $fields, $department, 'added');
        }
    }

    public function saveDocument(array $documentDetails): string
    {
        $id = $documentDetails['document_id'] ?? null;

        $fields = [
            'patient_id'       => $documentDetails['patient_id'],
            'document_type_id' => $documentDetails['document_type_id'],
        ];

        if (empty($id)) {
            $fields['created_by'] = Auth::id();
        } else {
            // deletes the files if there is existing document id
            DocumentFile::where('document_id', $id)->delete();
        }

        if (! empty($documentDetails['consultation_id'])) {
            $fields['consultation_id'] = $documentDetails['consultation_id'];
        }

        if (! empty($documentDetails['laboratory_id'])) {
            $fields['laboratory_id'] = $documentDetails['laboratory_id'];
        }

        if (! empty($documentDetails['radiology_id'])) {
            $fields['radiology_id'] = $documentDetails['radiology_id'];
        }

        $fields['last_modified_by'] = Auth::id();

        $document = Document::updateOrCreate(
            ['id' => $id],
            $fields,
        );

        return $document->id;
    }

    public function saveDocumentFile(UploadedFile $file, string $filePath): void
    {
        // store the file in storage/app/documents/
        $file->storeAs($filePath);
    }

    public function logAudit(
        string $departmentId,
        array $fields,
        string $department,
        string $action,
    ): void {
        $data = [
            'title'  => 'Document has been '.$action.'.',
            'fields' => $fields,
        ];

        $auditType = match ($action) {
            'added'    => AuditTypeEnum::ADD,
            'accessed' => AuditTypeEnum::VIEW,
            'updated'  => AuditTypeEnum::UPDATE,
            default    => AuditTypeEnum::DELETE,
        };

        if ($department === 'consultation') {
            ConsultationAudit::create([
                'consultation_id' => $departmentId,
                'audit_type_id'   => $auditType,
                'data'            => json_encode($data),
                'created_by'      => Auth::id(),
            ]);
        }

        if ($department === 'laboratory') {
            LaboratoryAudit::create([
                'laboratory_id' => $departmentId,
                'audit_type_id' => AuditTypeEnum::VIEW,
                'data'          => json_encode($data),
                'created_by'    => Auth::id(),
            ]);
        }

        if ($department === 'radiology') {
        }

        if ($department === 'patient') {
            PatientAudit::create([
                'patient_id'    => $departmentId,
                'audit_type_id' => AuditTypeEnum::VIEW,
                'data'          => json_encode($data),
                'created_by'    => Auth::id(),
            ]);
        }
    }
}
