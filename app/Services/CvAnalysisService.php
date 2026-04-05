<?php

namespace App\Services;

use App\Integrations\GeminiAI;
use App\Models\Candidate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CvAnalysisService
{
    public function __construct(
        protected GeminiAI $geminiAi
    ) {}

    public function analyze(UploadedFile $file): array
    {
        // 1. Storage
        $path = $file->store('cv_uploads', 'public');

        // 2. Placeholder for text extraction (MVP)
        $text = "Simulated text extraction from " . $file->getClientOriginalName();

        // 3. Call AI Integration
        $analysis = $this->geminiAi->analyzeCandidate($text);

        // 4. Store to Database
        $candidate = Candidate::create([
            'name' => $analysis['name'] ?? 'Unknown Candidate',
            'email' => $analysis['email'] ?? 'unknown@example.com',
            'phone' => $analysis['phone'] ?? null,
            'summary' => $analysis['summary'] ?? '',
            'score' => $analysis['score'] ?? 0,
            'raw_cv_path' => $path,
            'skills' => $analysis['skills'] ?? [],
            'technical_skills' => $analysis['technical_skills'] ?? [],
            'soft_skills' => $analysis['soft_skills'] ?? [],
            'tools' => $analysis['tools'] ?? [],
            'in_demand_skills' => $analysis['in_demand_skills'] ?? [],
            'job_matches' => $analysis['job_matches'] ?? [],
            'recommendation' => $analysis['recommendation'] ?? '',
        ]);

        return $candidate->toArray();
    }
}
