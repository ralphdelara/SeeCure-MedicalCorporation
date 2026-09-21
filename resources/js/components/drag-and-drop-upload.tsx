import React, { useState, useRef, DragEvent, ChangeEvent } from 'react';

// Define types for the component props
interface DragAndDropUploadProps {
    files: File[];
    onFilesChange: (files: File[]) => void;
}

export default function DragAndDropUpload({ files, onFilesChange }: DragAndDropUploadProps) {
    const [isDragActive, setIsDragActive] = useState<boolean>(false);
    const [errorMessage, setErrorMessage] = useState<string>('');

    const fileInputRef = useRef<HTMLInputElement | null>(null);

    const ALLOWED_EXTENSIONS: string[] = [
        'png',
        'jpg',
        'jpeg',
        'gif',
        'bmp',
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
    ];
    const acceptString: string = '.png, .jpg, .jpeg, .gif, .bmp, .pdf, .doc, .docx, .xls, .xlsx';

    const MAX_FILE_SIZE_BYTES = 15 * 1024 * 1024; // 15MB
    const MAX_FILE_COUNT = 5;

    const validateAndSetFiles = (incomingFiles: File[]): void => {
        setErrorMessage('');

        if (files.length >= MAX_FILE_COUNT) {
            setErrorMessage(`Maximum limit of ${MAX_FILE_COUNT} files reached.`);
            return;
        }

        const remainingSlots = MAX_FILE_COUNT - files.length;
        let filesToProcess = incomingFiles;
        let countWarning = '';

        if (incomingFiles.length > remainingSlots) {
            filesToProcess = incomingFiles.slice(0, remainingSlots);
            countWarning = `Only the first ${remainingSlots} valid file(s) were added due to the 5-file limit.`;
        }

        const validFiles: File[] = [];
        const invalidFormatFiles: string[] = [];
        const oversizedFiles: string[] = [];

        filesToProcess.forEach((file: File) => {
            const fileExtension = file.name.split('.').pop()?.toLowerCase();
            const isValidExtension = fileExtension && ALLOWED_EXTENSIONS.includes(fileExtension);

            if (!isValidExtension) {
                invalidFormatFiles.push(file.name);
            } else if (file.size > MAX_FILE_SIZE_BYTES) {
                oversizedFiles.push(file.name);
            } else {
                validFiles.push(file);
            }
        });

        let errors: string[] = [];
        if (countWarning) errors.push(countWarning);
        if (invalidFormatFiles.length > 0)
            errors.push(`Invalid format: ${invalidFormatFiles.join(', ')}`);
        if (oversizedFiles.length > 0) errors.push(`Exceeds 15MB: ${oversizedFiles.join(', ')}`);

        if (errors.length > 0) {
            setErrorMessage(errors.join(' | '));
        }

        if (validFiles.length > 0) {
            // Pass the combined array back up to the parent
            onFilesChange([...files, ...validFiles]);
        }
    };

    const handleDrag = (e: DragEvent<HTMLDivElement>): void => {
        e.preventDefault();
        e.stopPropagation();
        if (e.type === 'dragenter' || e.type === 'dragover') setIsDragActive(true);
        else if (e.type === 'dragleave') setIsDragActive(false);
    };

    const handleDrop = (e: DragEvent<HTMLDivElement>): void => {
        e.preventDefault();
        e.stopPropagation();
        setIsDragActive(false);
        if (e.dataTransfer?.files && e.dataTransfer.files.length > 0) {
            validateAndSetFiles(Array.from(e.dataTransfer.files));
        }
    };

    const handleChange = (e: ChangeEvent<HTMLInputElement>): void => {
        if (e.target.files && e.target.files.length > 0) {
            validateAndSetFiles(Array.from(e.target.files));
        }
        e.target.value = '';
    };

    const removeFile = (indexToRemove: number): void => {
        const updatedFiles = files.filter((_, index) => index !== indexToRemove);
        onFilesChange(updatedFiles); // Inform parent
        setErrorMessage('');
    };

    const clearAllFiles = (): void => {
        onFilesChange([]); // Inform parent
        setErrorMessage('');
    };

    return (
        <div style={{ fontFamily: 'Arial, sans-serif' }}>
            <div
                onDragEnter={handleDrag}
                onDragOver={handleDrag}
                onDragLeave={handleDrag}
                onDrop={handleDrop}
                onClick={() => fileInputRef.current?.click()}
                style={{
                    border: isDragActive ? '2px dashed #007bff' : '2px dashed #ccc',
                    backgroundColor: isDragActive ? '#f0f7ff' : '#fafafa',
                    borderRadius: '10px',
                    padding: '40px 20px',
                    textAlign: 'center',
                    cursor: files.length >= MAX_FILE_COUNT ? 'not-allowed' : 'pointer',
                    opacity: files.length >= MAX_FILE_COUNT ? 0.7 : 1,
                    transition: 'all 0.2s ease',
                    pointerEvents: files.length >= MAX_FILE_COUNT ? 'none' : 'auto',
                }}
            >
                <input
                    ref={fileInputRef}
                    type="file"
                    multiple
                    accept={acceptString}
                    onChange={handleChange}
                    disabled={files.length >= MAX_FILE_COUNT}
                    style={{ display: 'none' }}
                />
                <p style={{ margin: 0, fontSize: '16px', color: '#555' }}>
                    {files.length >= MAX_FILE_COUNT
                        ? 'Upload limit reached (5/5)'
                        : isDragActive
                          ? 'Drop your files here...'
                          : 'Drag & drop files here, or click to select'}
                </p>
                <span
                    style={{ fontSize: '12px', color: '#888', display: 'block', marginTop: '8px' }}
                >
                    Max 5 files • PNG, JPG, GIF, BMP, PDF, DOC(X), XLS(X) (Max 15MB/file)
                </span>
            </div>

            {errorMessage && (
                <div
                    style={{
                        marginTop: '15px',
                        color: '#dc3545',
                        fontSize: '14px',
                        backgroundColor: '#f8d7da',
                        padding: '10px',
                        borderRadius: '5px',
                    }}
                >
                    {errorMessage}
                </div>
            )}

            {files.length > 0 && (
                <div style={{ marginTop: '20px' }}>
                    <div
                        style={{
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'center',
                            marginBottom: '10px',
                        }}
                    >
                        <h5 style={{ margin: 0 }}>
                            Selected Files ({files.length}/{MAX_FILE_COUNT}):
                        </h5>
                        <button
                            type="button"
                            onClick={clearAllFiles}
                            style={{
                                background: 'none',
                                border: 'none',
                                color: '#6c757d',
                                textDecoration: 'underline',
                                cursor: 'pointer',
                            }}
                        >
                            Clear All
                        </button>
                    </div>
                    <ul style={{ padding: 0, listStyleType: 'none' }}>
                        {files.map((file, index) => (
                            <li
                                key={index}
                                style={{
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'center',
                                    padding: '8px 12px',
                                    marginBottom: '6px',
                                    backgroundColor: '#f8f9fa',
                                    borderRadius: '5px',
                                    border: '1px solid #e9ecef',
                                    fontSize: '14px',
                                }}
                            >
                                <span
                                    style={{
                                        textOverflow: 'ellipsis',
                                        overflow: 'hidden',
                                        whiteSpace: 'nowrap',
                                        maxWidth: '80%',
                                    }}
                                >
                                    <strong>{file.name}</strong>{' '}
                                    <span style={{ color: '#6c757d', fontSize: '12px' }}>
                                        ({(file.size / (1024 * 1024)).toFixed(2)} MB)
                                    </span>
                                </span>
                                <button
                                    type="button"
                                    onClick={() => removeFile(index)}
                                    style={{
                                        background: 'none',
                                        border: 'none',
                                        color: '#dc3545',
                                        fontSize: '16px',
                                        fontWeight: 'bold',
                                        cursor: 'pointer',
                                    }}
                                >
                                    &times;
                                </button>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}
