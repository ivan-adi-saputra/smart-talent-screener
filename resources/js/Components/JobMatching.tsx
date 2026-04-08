import { Card } from "./ui/card";
import { Badge } from "./ui/badge";
import { Button } from "./ui/button";
import {
    Briefcase,
    MapPin,
    DollarSign,
    TrendingUp,
    ExternalLink,
} from "lucide-react";

interface Job {
    id: string;
    title: string;
    company: string;
    location: string;
    salary: string;
    matchScore: number;
    type: string;
    skills: string[];
    logo: string;
}

const mockJobs: Job[] = [
    {
        id: "1",
        title: "Senior Frontend Developer",
        company: "TechCorp Inc.",
        location: "San Francisco, CA",
        salary: "$120k - $160k",
        matchScore: 95,
        type: "Full-time",
        skills: ["React", "TypeScript", "Node.js"],
        logo: "🚀",
    },
    {
        id: "2",
        title: "Full Stack Engineer",
        company: "StartupXYZ",
        location: "Remote",
        salary: "$110k - $150k",
        matchScore: 92,
        type: "Full-time",
        skills: ["JavaScript", "Python", "Docker"],
        logo: "⚡",
    },
    {
        id: "3",
        title: "React Developer",
        company: "Digital Solutions",
        location: "New York, NY",
        salary: "$100k - $140k",
        matchScore: 88,
        type: "Full-time",
        skills: ["React", "JavaScript", "Git"],
        logo: "🎯",
    },
    {
        id: "4",
        title: "Software Engineer",
        company: "Innovation Labs",
        location: "Austin, TX",
        salary: "$115k - $155k",
        matchScore: 85,
        type: "Full-time",
        skills: ["TypeScript", "React", "Python"],
        logo: "💡",
    },
    {
        id: "5",
        title: "Lead Developer",
        company: "CloudTech",
        location: "Seattle, WA",
        salary: "$130k - $170k",
        matchScore: 82,
        type: "Full-time",
        skills: ["Leadership", "React", "Node.js"],
        logo: "☁️",
    },
    {
        id: "6",
        title: "Frontend Architect",
        company: "Enterprise Systems",
        location: "Boston, MA",
        salary: "$140k - $180k",
        matchScore: 80,
        type: "Full-time",
        skills: ["React", "TypeScript", "Leadership"],
        logo: "🏢",
    },
];

export function JobMatching() {
    const getMatchColor = (score: number) => {
        if (score >= 90) return "text-green-600 bg-green-50";
        if (score >= 80) return "text-blue-600 bg-blue-50";
        return "text-orange-600 bg-orange-50";
    };

    return (
        <div className="py-12 px-6 bg-white">
            <div className="mx-auto max-w-7xl">
                <div className="text-center mb-10">
                    <h2 className="text-3xl text-slate-900 mb-3">
                        Job Role Matching
                    </h2>
                    <p className="text-slate-600">
                        Top opportunities based on your skills and experience
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {mockJobs.map((job) => (
                        <Card
                            key={job.id}
                            className="p-6 hover:shadow-lg transition-shadow bg-white"
                        >
                            <div className="flex items-start justify-between mb-4">
                                <div className="flex items-start gap-3">
                                    <div className="text-3xl">{job.logo}</div>
                                    <div>
                                        <h3 className="text-slate-900 mb-1">
                                            {job.title}
                                        </h3>
                                        <p className="text-sm text-slate-600">
                                            {job.company}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    className={`px-3 py-1 rounded-full text-xs ${getMatchColor(job.matchScore)}`}
                                >
                                    {job.matchScore}% Match
                                </div>
                            </div>

                            <div className="space-y-2 mb-4">
                                <div className="flex items-center gap-2 text-sm text-slate-600">
                                    <MapPin className="h-4 w-4" />
                                    <span>{job.location}</span>
                                </div>
                                <div className="flex items-center gap-2 text-sm text-slate-600">
                                    <DollarSign className="h-4 w-4" />
                                    <span>{job.salary}</span>
                                </div>
                                <div className="flex items-center gap-2 text-sm text-slate-600">
                                    <Briefcase className="h-4 w-4" />
                                    <span>{job.type}</span>
                                </div>
                            </div>

                            <div className="mb-4">
                                <p className="text-xs text-slate-500 mb-2">
                                    Required Skills
                                </p>
                                <div className="flex flex-wrap gap-2">
                                    {job.skills.map((skill, index) => (
                                        <Badge
                                            key={index}
                                            variant="secondary"
                                            className="text-xs bg-slate-100 text-slate-700"
                                        >
                                            {skill}
                                        </Badge>
                                    ))}
                                </div>
                            </div>

                            <Button className="w-full bg-blue-600 hover:bg-blue-700 text-white">
                                View Details
                                <ExternalLink className="ml-2 h-4 w-4" />
                            </Button>
                        </Card>
                    ))}
                </div>

                <div className="text-center mt-10">
                    <Button
                        variant="outline"
                        size="lg"
                        className="border-slate-300"
                    >
                        <TrendingUp className="mr-2 h-5 w-5" />
                        View All Matches
                    </Button>
                </div>
            </div>
        </div>
    );
}
