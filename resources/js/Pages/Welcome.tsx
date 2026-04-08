import { PageProps } from "@/types";
import { Header } from "@/Components/layouts/Header";
import { Footer } from "@/Components/layouts/Footer";
import { useState } from "react";
import { ResumeUpload } from "@/Components/ResumeUpload";
import { SkillAnalysis } from "@/Components/SkillAnalysis";
import { JobMatching } from "@/Components/JobMatching";
import { AIRecommendations } from "@/Components/AIRecommendations";
import { Hero } from "@/Components/Hero";

export default function Welcome({
    auth,
    laravelVersion,
    phpVersion,
}: PageProps<{ laravelVersion: string; phpVersion: string }>) {
    const [hasUploadedResume, setHasUploadedResume] = useState(false);
    const [showUploadSection, setShowUploadSection] = useState(false);

    const handleGetStarted = () => {
        setShowUploadSection(true);
        // Smooth scroll to upload section
        setTimeout(() => {
            document
                .getElementById("upload-section")
                ?.scrollIntoView({ behavior: "smooth" });
        }, 100);
    };

    const handleResumeUpload = (fileName: string) => {
        console.log("Uploaded file:", fileName);
        setHasUploadedResume(true);
        // Smooth scroll to analysis section
        setTimeout(() => {
            document
                .getElementById("analysis-section")
                ?.scrollIntoView({ behavior: "smooth" });
        }, 500);
    };
    return (
        <div className="min-h-screen bg-white">
            <Header />

            <main>
                <Hero onGetStarted={handleGetStarted} />

                <div id="upload-section">
                    <ResumeUpload onUpload={handleResumeUpload} />
                </div>

                {hasUploadedResume && (
                    <div id="analysis-section" className="space-y-0">
                        <SkillAnalysis />
                        <JobMatching />
                        <AIRecommendations />
                    </div>
                )}
            </main>

            <Footer />
        </div>
    );
}
