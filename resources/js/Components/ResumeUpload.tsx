import { Upload, FileText, Loader2 } from "lucide-react";
import { useState } from "react";
import { Card } from "./ui/card";
import { Button } from "./ui/button";

interface ResumeUploadProps {
    onUpload: (fileName: string) => void;
}

export function ResumeUpload({ onUpload }: ResumeUploadProps) {
    const [isDragging, setIsDragging] = useState(false);
    const [isUploading, setIsUploading] = useState(false);

    const handleDragOver = (e: React.DragEvent) => {
        e.preventDefault();
        setIsDragging(true);
    };

    const handleDragLeave = () => {
        setIsDragging(false);
    };

    const handleDrop = (e: React.DragEvent) => {
        e.preventDefault();
        setIsDragging(false);
        const file = e.dataTransfer.files[0];
        if (file) {
            handleFileUpload(file);
        }
    };

    const handleFileSelect = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            handleFileUpload(file);
        }
    };

    const handleFileUpload = (file: File) => {
        setIsUploading(true);
        // Simulate upload delay
        setTimeout(() => {
            setIsUploading(false);
            onUpload(file.name);
        }, 2000);
    };

    return (
        <div className="py-12 px-6">
            <div className="mx-auto max-w-3xl">
                <div className="text-center mb-8">
                    <h2 className="text-3xl text-slate-900 mb-3">
                        Upload Your Resume
                    </h2>
                    <p className="text-slate-600">
                        Support for PDF, DOC, and DOCX files up to 5MB
                    </p>
                </div>

                <Card
                    className={`border-2 border-dashed transition-all ${
                        isDragging
                            ? "border-blue-500 bg-blue-50"
                            : "border-slate-300 bg-white"
                    }`}
                    onDragOver={handleDragOver}
                    onDragLeave={handleDragLeave}
                    onDrop={handleDrop}
                >
                    <div className="p-12 text-center">
                        {isUploading ? (
                            <div className="flex flex-col items-center">
                                <Loader2 className="h-16 w-16 text-blue-600 animate-spin mb-4" />
                                <p className="text-slate-700">
                                    Analyzing your resume...
                                </p>
                            </div>
                        ) : (
                            <>
                                <div className="mx-auto w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-6">
                                    <Upload className="h-8 w-8 text-blue-600" />
                                </div>
                                <h3 className="text-slate-900 mb-2">
                                    Drop your resume here, or{" "}
                                    <label
                                        htmlFor="file-upload"
                                        className="text-blue-600 hover:text-blue-700 cursor-pointer underline"
                                    >
                                        browse
                                    </label>
                                </h3>
                                <p className="text-sm text-slate-500 mb-6">
                                    PDF, DOC, DOCX up to 5MB
                                </p>
                                <input
                                    id="file-upload"
                                    type="file"
                                    className="hidden"
                                    accept=".pdf,.doc,.docx"
                                    onChange={handleFileSelect}
                                />
                                <div className="flex items-center justify-center gap-4 pt-4">
                                    <div className="flex items-center gap-2 text-sm text-slate-600">
                                        <FileText className="h-4 w-4" />
                                        <span>Secure & Private</span>
                                    </div>
                                    <div className="flex items-center gap-2 text-sm text-slate-600">
                                        <svg
                                            className="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth={2}
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                            />
                                        </svg>
                                        <span>ATS Compatible</span>
                                    </div>
                                </div>
                            </>
                        )}
                    </div>
                </Card>

                <div className="mt-8 text-center">
                    <Button variant="ghost" className="text-slate-600">
                        Or try with a sample resume
                    </Button>
                </div>
            </div>
        </div>
    );
}
