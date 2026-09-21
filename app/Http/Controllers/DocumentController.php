<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFile;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Storage;

class DocumentController extends Controller
{
    public function addOrUpdateDocument(Request $request): void
    {
        $request->validate([
            'patient_id'       => 'required',
            'document_type_id' => 'required',
            'data'             => 'required',
        ]);

        $documentDetails = $request->only(
            'document_id',
            'document_type_id',
            'patient_id',
            'consultation_id',
            'laboratory_id',
            'radiology_id',
            'data',
        );

        app(DocumentService::class)->addOrUpdateDocument($documentDetails);
    }

    public function downloadDocument(string $departmentId, string $fileName, string $department)
    {
        if (! in_array($department, ['patient', 'consultation', 'laboratory', 'radiology'])) {
            abort(404);
        }

        $path = 'documents/'.$fileName;
        $absolutePath = storage_path('app/private/'.$path);

        if (! file_exists($absolutePath)) {
            abort(404, 'File physically missing on server.');
        }

        $fields = [['field' => 'File Name', 'to' => $fileName]];
        app(DocumentService::class)->logAudit($departmentId, $fields, $department, 'accessed');

        return response()->download($absolutePath, $fileName, [
            'Content-Type' => mime_content_type($absolutePath),
        ]);
    }

    public function deleteDocument(string $documentId, string $departmentId, string $department): void
    {
        $documentFiles = DocumentFile::where('document_id', $documentId)->get();
        $fields = [];
        foreach ($documentFiles as $file) {
            $fields[] = ['field' => 'File Path', 'to' => $file->file_path];
            $fields[] = ['field' => 'File Name', 'to' => $file->file_name];
            $fields[] = ['field' => 'File Size', 'to' => $file->file_size];
            $fields[] = ['field' => 'File MIME Type', 'to' => $file->file_mime_type];
            $fields[] = ['field' => 'File EXT', 'to' => $file->ext];

            if (Storage::disk('local')->exists($file->file_path)) {
                Storage::disk('local')->delete($file->file_path);
            }
        }

        Document::destroy($documentId);

        app(DocumentService::class)->logAudit($departmentId, $fields, $department, 'deleted');
    }
}
