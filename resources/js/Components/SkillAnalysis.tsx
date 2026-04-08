import { Card } from "./ui/card";
import { Progress } from "./ui/progress";
import { Badge } from "./ui/badge";
import { TrendingUp, Award, Target } from "lucide-react";

interface Skill {
    name: string;
    level: number;
    category: "technical" | "soft" | "tools";
    inDemand?: boolean;
}

const mockSkills: Skill[] = [
    { name: "JavaScript", level: 92, category: "technical", inDemand: true },
    { name: "React", level: 88, category: "technical", inDemand: true },
    { name: "TypeScript", level: 85, category: "technical", inDemand: true },
    { name: "Node.js", level: 78, category: "technical" },
    { name: "Python", level: 75, category: "technical", inDemand: true },
    { name: "Leadership", level: 82, category: "soft" },
    { name: "Communication", level: 90, category: "soft" },
    { name: "Problem Solving", level: 87, category: "soft" },
    { name: "Git", level: 85, category: "tools" },
    { name: "Docker", level: 70, category: "tools", inDemand: true },
];

export function SkillAnalysis() {
    const technicalSkills = mockSkills.filter(
        (s) => s.category === "technical",
    );
    const softSkills = mockSkills.filter((s) => s.category === "soft");
    const toolSkills = mockSkills.filter((s) => s.category === "tools");

    const avgScore = Math.round(
        mockSkills.reduce((acc, s) => acc + s.level, 0) / mockSkills.length,
    );
    const inDemandCount = mockSkills.filter((s) => s.inDemand).length;

    return (
        <div className="py-12 px-6 bg-slate-50">
            <div className="mx-auto max-w-7xl">
                <div className="text-center mb-10">
                    <h2 className="text-3xl text-slate-900 mb-3">
                        Skills Analysis
                    </h2>
                    <p className="text-slate-600">
                        Comprehensive breakdown of your professional
                        competencies
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <Card className="p-6 bg-white">
                        <div className="flex items-start justify-between">
                            <div>
                                <p className="text-sm text-slate-600 mb-1">
                                    Overall Score
                                </p>
                                <p className="text-3xl text-slate-900">
                                    {avgScore}%
                                </p>
                                <p className="text-xs text-green-600 mt-1 flex items-center gap-1">
                                    <TrendingUp className="h-3 w-3" />
                                    Above average
                                </p>
                            </div>
                            <div className="rounded-full bg-blue-100 p-3">
                                <Award className="h-6 w-6 text-blue-600" />
                            </div>
                        </div>
                    </Card>

                    <Card className="p-6 bg-white">
                        <div className="flex items-start justify-between">
                            <div>
                                <p className="text-sm text-slate-600 mb-1">
                                    Skills Detected
                                </p>
                                <p className="text-3xl text-slate-900">
                                    {mockSkills.length}
                                </p>
                                <p className="text-xs text-slate-500 mt-1">
                                    Across 3 categories
                                </p>
                            </div>
                            <div className="rounded-full bg-green-100 p-3">
                                <Target className="h-6 w-6 text-green-600" />
                            </div>
                        </div>
                    </Card>

                    <Card className="p-6 bg-white">
                        <div className="flex items-start justify-between">
                            <div>
                                <p className="text-sm text-slate-600 mb-1">
                                    In-Demand Skills
                                </p>
                                <p className="text-3xl text-slate-900">
                                    {inDemandCount}
                                </p>
                                <p className="text-xs text-slate-500 mt-1">
                                    Market trending
                                </p>
                            </div>
                            <div className="rounded-full bg-purple-100 p-3">
                                <TrendingUp className="h-6 w-6 text-purple-600" />
                            </div>
                        </div>
                    </Card>
                </div>

                {/* Skills Breakdown */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Technical Skills */}
                    <Card className="p-6 bg-white">
                        <h3 className="text-lg text-slate-900 mb-4 flex items-center gap-2">
                            <span className="w-2 h-2 rounded-full bg-blue-600"></span>
                            Technical Skills
                        </h3>
                        <div className="space-y-4">
                            {technicalSkills.map((skill, index) => (
                                <div key={index}>
                                    <div className="flex items-center justify-between mb-2">
                                        <div className="flex items-center gap-2">
                                            <span className="text-sm text-slate-700">
                                                {skill.name}
                                            </span>
                                            {skill.inDemand && (
                                                <Badge
                                                    variant="secondary"
                                                    className="text-xs bg-green-100 text-green-700 border-green-200"
                                                >
                                                    Hot
                                                </Badge>
                                            )}
                                        </div>
                                        <span className="text-sm text-slate-600">
                                            {skill.level}%
                                        </span>
                                    </div>
                                    <Progress
                                        value={skill.level}
                                        className="h-2"
                                    />
                                </div>
                            ))}
                        </div>
                    </Card>

                    {/* Soft Skills */}
                    <Card className="p-6 bg-white">
                        <h3 className="text-lg text-slate-900 mb-4 flex items-center gap-2">
                            <span className="w-2 h-2 rounded-full bg-green-600"></span>
                            Soft Skills
                        </h3>
                        <div className="space-y-4">
                            {softSkills.map((skill, index) => (
                                <div key={index}>
                                    <div className="flex items-center justify-between mb-2">
                                        <span className="text-sm text-slate-700">
                                            {skill.name}
                                        </span>
                                        <span className="text-sm text-slate-600">
                                            {skill.level}%
                                        </span>
                                    </div>
                                    <Progress
                                        value={skill.level}
                                        className="h-2"
                                    />
                                </div>
                            ))}
                        </div>
                    </Card>

                    {/* Tools */}
                    <Card className="p-6 bg-white">
                        <h3 className="text-lg text-slate-900 mb-4 flex items-center gap-2">
                            <span className="w-2 h-2 rounded-full bg-purple-600"></span>
                            Tools & Technologies
                        </h3>
                        <div className="space-y-4">
                            {toolSkills.map((skill, index) => (
                                <div key={index}>
                                    <div className="flex items-center justify-between mb-2">
                                        <div className="flex items-center gap-2">
                                            <span className="text-sm text-slate-700">
                                                {skill.name}
                                            </span>
                                            {skill.inDemand && (
                                                <Badge
                                                    variant="secondary"
                                                    className="text-xs bg-green-100 text-green-700 border-green-200"
                                                >
                                                    Hot
                                                </Badge>
                                            )}
                                        </div>
                                        <span className="text-sm text-slate-600">
                                            {skill.level}%
                                        </span>
                                    </div>
                                    <Progress
                                        value={skill.level}
                                        className="h-2"
                                    />
                                </div>
                            ))}
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    );
}
