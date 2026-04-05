<?php

namespace App\Services;

use App\Services\CvParsingService;
use App\Integrations\GeminiAI;
use App\Models\Candidate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CvAnalysisService
{
    public function __construct(
        protected CvParsingService $cvParsingService,
        protected GeminiAI $geminiAi
    ) {}

    public function analyze(UploadedFile $file): Candidate
    {
        // 1. Storage
        $path = $file->store('cv_uploads', 'public');

        // 2. CV Parsing
        $parsedData = $this->cvParsingService->parse($file);
        $rawText = $parsedData['raw_text'] ?? '';

        // 3. Call AI Integration (Pass real text)
        $analysis = $this->geminiAi->analyzeCandidate($rawText);

        // 4. Store to Database (Merge parsed data with AI results)
        return Candidate::create([
            'name' => $analysis['name'] ?? ($parsedData['name'] ?? 'Unknown Candidate'),
            'email' => $analysis['email'] ?? ($parsedData['email'] ?? 'unknown@example.com'),
            'phone' => $this->cvParsingService->normalizePhoneNumber($analysis['phone'] ?? ($parsedData['phone'] ?? '')),
            'summary' => $analysis['summary'] ?? '',
            'score' => $analysis['score'] ?? 0,
            'raw_cv_path' => $path,
            'skills' => $analysis['skills'] ?? [],
            'technical_skills' => $analysis['technical_skills'] ?? [],
            'soft_skills' => $analysis['soft_skills'] ?? [],
            'tools' => $analysis['tools'] ?? [],
            'in_demand_skills' => $analysis['in_demand_skills'] ?? [],
            'job_matches' => $analysis['job_matches'] ?? [],
            'recommendation' => $analysis['recommendation'] ?? [],
            'cv_recommendation' => $analysis['cv_recommendation'] ?? [],
        ]);
    }
}
