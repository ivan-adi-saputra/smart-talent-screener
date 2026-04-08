export interface JobMatch {
    role: string;
    match_percentage: number;
}

export interface CandidateAnalysis {
    id?: number;
    name: string;
    email: string;
    phone: string;
    summary: string;
    score: number;
    skills: string[];
    technical_skills: string[];
    soft_skills: string[];
    tools: string[];
    in_demand_skills: string[];
    job_matches: JobMatch[];
    recommendation: {
        strengths: string[];
        weaknesses: string[];
        suggestions: string[];
    };
    cv_recommendation: {
        good_points: string[];
        improvement_points: string[];
    };
}

export interface AnalyzeCVRequest {
    cv_file: File;
}

export interface AnalyzeCVResponse {
    status: string;
    data: CandidateAnalysis;
    message?: string;
}
