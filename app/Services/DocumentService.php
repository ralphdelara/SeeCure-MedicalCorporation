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
use Storage;

class DocumentService
{
    public function addOrUpdateDocument(array $documentDetails): void
    {
        $documentType = DocumentTypeEnum::tryFrom($documentDetails['document_type_id']);

        if (empty($documentType)) {
            abort(404);
        }

        $documentId = $this->saveDocument($documentDetails);

        if (
            DocumentTypeEnum::tryFrom($documentDetails['document_type_id'])
            === DocumentTypeEnum::FILE
        ) {
            $this->uploadFiles($documentId, $documentDetails);
        }

        if (
            DocumentTypeEnum::tryFrom($documentDetails['document_type_id'])
            === DocumentTypeEnum::WEBCAM
        ) {
            $this->uploadBase64String($documentId, $documentDetails);
        }
    }

    public function uploadFiles(string $documentId, array $documentDetails): void
    {
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

    public function uploadBase64String(string $documentId, array $documentDetails): void
    {
        $base64Data = $documentDetails['data'];

        // Separate the metadata prefix from the base64 encoded stream
        // Example data sequence: "data:image/jpeg;base64,/9j/4AAQSkZJRg..."
        if (! preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            abort(400);
        }

        $extension = $matches[1]; // Extracts 'jpeg', 'png', etc.
        $pureBase64 = substr($base64Data, strpos($base64Data, ',') + 1);
        $binaryData = base64_decode($pureBase64);

        if ($binaryData === false) {
            abort(400);
        }

        $fileName = Str::uuid7().'.'.$extension;
        $filePath = 'documents/'.$fileName;

        // Write the binary stream to a temporary location on your server
        $tmpFilePath = sys_get_temp_dir().'/'.$fileName;
        file_put_contents($tmpFilePath, $binaryData);

        // Instantiate an UploadedFile object to mock an HTTP upload request
        $originalName = 'webcam_capture.'.$extension;
        $mimeType = 'image/'.$extension;

        $file = new UploadedFile(
            $tmpFilePath,
            $originalName,
            $mimeType,
            null,
            true, // Set test mode to TRUE to bypass PHP's internal is_uploaded_file() check
        );

        // You can now use all your favorite file methods!
        $fileSize = $file->getSize();                      // Output example: 45201 (in bytes)
        $fileMimeType = $file->getMimeType();                  // Output example: "image/jpeg"
        $fileExt = $file->getClientOriginalExtension();   // Output example: "jpeg" or "jpg"

        // Use Laravel's Storage facade to store the file
        Storage::put($filePath, file_get_contents($file->getRealPath()));

        // Clean up the temp file from the server's temp directory
        if (file_exists($tmpFilePath)) {
            unlink($tmpFilePath);
        }

        DocumentFile::create([
            'document_id'    => $documentId,
            'file_path'      => $filePath,
            'file_name'      => $fileName,
            'file_size'      => $fileSize,
            'file_mime_type' => $fileMimeType,
            'file_ext'       => $fileExt,
        ]);

        $auditData = $this->getAuditData($documentDetails);

        $fields = [
            ['field' => 'File Path', 'to' => $filePath],
            ['field' => 'File Name', 'to' => $fileName],
            ['field' => 'File Size', 'to' => $fileSize],
            ['field' => 'File MIME Type', 'to' => $fileMimeType],
            ['field' => 'File EXT', 'to' => $fileExt],
        ];

        $this->logAudit($auditData['departmentId'], $fields, $auditData['department'], 'added');
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
                'created_by'      => Auth::id() ?? Auth::systemUser()->id,
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

    public function getAuditData(array $documentDetails): array
    {
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

        return [
            'departmentId' => $departmentId,
            'department'   => $department,
        ];
    }
}
