import { Card } from "./ui/card";
import { Badge } from "./ui/badge";
import { Button } from "./ui/button";
import {
    Sparkles,
    AlertCircle,
    CheckCircle2,
    Lightbulb,
    ArrowRight,
} from "lucide-react";

interface Recommendation {
    id: string;
    type: "critical" | "improvement" | "suggestion";
    category: string;
    title: string;
    description: string;
    impact: "high" | "medium" | "low";
}

const mockRecommendations: Recommendation[] = [
    {
        id: "1",
        type: "critical",
        category: "Skills Gap",
        title: "Add Cloud Computing Skills",
        description:
            "Based on your target roles, learning AWS or Azure would significantly increase your competitiveness. 78% of matched positions require cloud expertise.",
        impact: "high",
    },
    {
        id: "2",
        type: "improvement",
        category: "Resume Format",
        title: "Quantify Your Achievements",
        description:
            'Include specific metrics and numbers in your accomplishments. For example, "Improved app performance by 40%" is more impactful than "Improved app performance".',
        impact: "high",
    },
    {
        id: "3",
        type: "improvement",
        category: "Keywords",
        title: "Optimize ATS Keywords",
        description:
            'Your resume is missing key industry terms like "agile methodology", "CI/CD", and "microservices" that appear in 60% of target job descriptions.',
        impact: "medium",
    },
    {
        id: "4",
        type: "suggestion",
        category: "Projects",
        title: "Highlight Open Source Contributions",
        description:
            "Adding links to your GitHub repositories and open source contributions can demonstrate hands-on experience and community engagement.",
        impact: "medium",
    },
    {
        id: "5",
        type: "suggestion",
        category: "Certifications",
        title: "Consider Getting Certified",
        description:
            "Certifications in React, AWS, or Kubernetes would strengthen your profile. These appear frequently in job requirements for senior positions.",
        impact: "low",
    },
    {
        id: "6",
        type: "improvement",
        category: "Experience",
        title: "Expand Leadership Examples",
        description:
            "For senior roles, emphasize team leadership, mentoring, and cross-functional collaboration experiences more prominently.",
        impact: "high",
    },
];

export function AIRecommendations() {
    const getIcon = (type: string) => {
        switch (type) {
            case "critical":
                return <AlertCircle className="h-5 w-5 text-red-600" />;
            case "improvement":
                return <Lightbulb className="h-5 w-5 text-orange-600" />;
            case "suggestion":
                return <CheckCircle2 className="h-5 w-5 text-blue-600" />;
            default:
                return <Sparkles className="h-5 w-5" />;
        }
    };

    const getTypeColor = (type: string) => {
        switch (type) {
            case "critical":
                return "bg-red-50 border-red-200";
            case "improvement":
                return "bg-orange-50 border-orange-200";
            case "suggestion":
                return "bg-blue-50 border-blue-200";
            default:
                return "bg-slate-50 border-slate-200";
        }
    };

    const getImpactBadge = (impact: string) => {
        const colors = {
            high: "bg-red-100 text-red-700",
            medium: "bg-orange-100 text-orange-700",
            low: "bg-blue-100 text-blue-700",
        };
        return colors[impact as keyof typeof colors] || colors.low;
    };

    const criticalCount = mockRecommendations.filter(
        (r) => r.type === "critical",
    ).length;
    const improvementCount = mockRecommendations.filter(
        (r) => r.type === "improvement",
    ).length;

    return (
        <div className="py-12 px-6 bg-slate-50">
            <div className="mx-auto max-w-7xl">
                <div className="text-center mb-10">
                    <div className="flex items-center justify-center gap-2 mb-3">
                        <Sparkles className="h-8 w-8 text-blue-600" />
                        <h2 className="text-3xl text-slate-900">
                            AI-Powered Recommendations
                        </h2>
                    </div>
                    <p className="text-slate-600">
                        Personalized insights to optimize your resume and boost
                        your chances
                    </p>
                </div>

                {/* Summary Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <Card className="p-6 bg-white text-center">
                        <div className="text-3xl mb-2">
                            {mockRecommendations.length}
                        </div>
                        <p className="text-sm text-slate-600">
                            Total Recommendations
                        </p>
                    </Card>
                    <Card className="p-6 bg-white text-center">
                        <div className="text-3xl mb-2 text-red-600">
                            {criticalCount}
                        </div>
                        <p className="text-sm text-slate-600">
                            Critical Actions
                        </p>
                    </Card>
                    <Card className="p-6 bg-white text-center">
                        <div className="text-3xl mb-2 text-orange-600">
                            {improvementCount}
                        </div>
                        <p className="text-sm text-slate-600">Improvements</p>
                    </Card>
                </div>

                {/* Recommendations Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {mockRecommendations.map((rec) => (
                        <Card
                            key={rec.id}
                            className={`p-6 border-l-4 ${getTypeColor(rec.type)}`}
                        >
                            <div className="flex items-start gap-4">
                                <div className="mt-1">{getIcon(rec.type)}</div>
                                <div className="flex-1">
                                    <div className="flex items-start justify-between mb-2">
                                        <div>
                                            <div className="flex items-center gap-2 mb-1">
                                                <h3 className="text-slate-900">
                                                    {rec.title}
                                                </h3>
                                            </div>
                                            <p className="text-xs text-slate-500">
                                                {rec.category}
                                            </p>
                                        </div>
                                        <Badge
                                            className={`text-xs ${getImpactBadge(rec.impact)}`}
                                        >
                                            {rec.impact} impact
                                        </Badge>
                                    </div>
                                    <p className="text-sm text-slate-600 mb-4">
                                        {rec.description}
                                    </p>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        className="text-blue-600 hover:text-blue-700 px-0"
                                    >
                                        Learn more
                                        <ArrowRight className="ml-1 h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                        </Card>
                    ))}
                </div>

                {/* Action Button */}
                <div className="text-center mt-10">
                    <Button
                        size="lg"
                        className="bg-blue-600 hover:bg-blue-700 text-white"
                    >
                        <Sparkles className="mr-2 h-5 w-5" />
                        Apply All Recommendations
                    </Button>
                </div>
            </div>
        </div>
    );
}
