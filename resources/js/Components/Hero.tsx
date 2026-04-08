import { Upload, Sparkles } from "lucide-react";
import { Button } from "./ui/button";

interface HeroProps {
    onGetStarted: () => void;
}

export function Hero({ onGetStarted }: HeroProps) {
    return (
        <div className="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white py-20 sm:py-32">
            <div className="mx-auto max-w-7xl px-6 lg:px-8">
                <div className="mx-auto max-w-2xl text-center">
                    <div className="mb-8 flex justify-center">
                        <div className="relative rounded-full px-4 py-1.5 text-sm bg-blue-50 text-blue-700 ring-1 ring-blue-600/10">
                            <span className="flex items-center gap-2">
                                <Sparkles className="h-4 w-4" />
                                AI-Powered Analysis
                            </span>
                        </div>
                    </div>
                    <h1 className="text-5xl sm:text-6xl tracking-tight text-slate-900 mb-6">
                        Optimize Your Resume with AI
                    </h1>
                    <p className="text-lg text-slate-600 mb-10 max-w-xl mx-auto">
                        Upload your resume and get instant insights on skills,
                        job matching, and personalized recommendations to land
                        your dream job.
                    </p>
                    <div className="flex items-center justify-center gap-4">
                        <Button
                            onClick={onGetStarted}
                            size="lg"
                            className="bg-blue-600 hover:bg-blue-700 text-white px-8"
                        >
                            <Upload className="mr-2 h-5 w-5" />
                            Upload Resume
                        </Button>
                        <Button
                            variant="outline"
                            size="lg"
                            className="border-slate-300"
                        >
                            View Demo
                        </Button>
                    </div>
                </div>

                <div className="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-3 text-center">
                    <div className="flex flex-col items-center">
                        <div className="rounded-full bg-blue-100 p-3 mb-4">
                            <Sparkles className="h-6 w-6 text-blue-600" />
                        </div>
                        <h3 className="text-slate-900 mb-2">AI Analysis</h3>
                        <p className="text-sm text-slate-600">
                            Advanced algorithms analyze your resume in seconds
                        </p>
                    </div>
                    <div className="flex flex-col items-center">
                        <div className="rounded-full bg-green-100 p-3 mb-4">
                            <svg
                                className="h-6 w-6 text-green-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <h3 className="text-slate-900 mb-2">Skill Matching</h3>
                        <p className="text-sm text-slate-600">
                            Match your skills with top job opportunities
                        </p>
                    </div>
                    <div className="flex flex-col items-center">
                        <div className="rounded-full bg-purple-100 p-3 mb-4">
                            <svg
                                className="h-6 w-6 text-purple-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <h3 className="text-slate-900 mb-2">
                            Instant Feedback
                        </h3>
                        <p className="text-sm text-slate-600">
                            Get actionable recommendations immediately
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}
