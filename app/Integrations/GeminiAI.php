<?php

namespace App\Integrations;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAI
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key') ?? '';
        $this->model = config('services.gemini.model');
        $this->baseUrl = config('services.gemini.base_url');
    }

    public function analyzeCandidate(string $text): array
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API key is not set. Using fallback simulation.');
            return $this->fallbackResponse($text);
        }

        try {
            $prompt = $this->getPrompt($text);
            $url = "{$this->baseUrl}/{$this->model}:generateContent";
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->apiKey,
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->failed()) {
                Log::error("Gemini API request failed: " . $response->body());
                return $this->fallbackResponse($text);
            }

            $result = $response->json();
            $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$content) {
                Log::error("Invalid response format from Gemini API: " . $response->body());
                return $this->fallbackResponse($text);
            }

            return json_decode($content, true) ?: $this->fallbackResponse($text);

        } catch (\Exception $e) {
            Log::error('Gemini Analysis Error: ' . $e->getMessage());
            return $this->fallbackResponse($text);
        }
    }

    protected function getPrompt(string $text): string
    {
        return <<<PROMPT
You are an expert HR Recruiter and Technical Screener. 
Analyze the following raw CV text and extract information into a strict JSON format.

RAW CV TEXT:
{$text}

JSON STRUCTURE REQUIRED:
{
    "name": "Full Name",
    "email": "Email Address",
    "phone": "Phone Number",
    "summary": "Professional summary (max 3 sentences)",
    "score": 0-100 (integer based on overall quality),
    "skills": ["Skill 1", "Skill 2"],
    "technical_skills": ["Tech 1", "Tech 2"],
    "soft_skills": ["Soft 1", "Soft 2"],
    "tools": ["Tool 1", "Tool 2"],
    "in_demand_skills": ["In-demand 1", "In-demand 2"],
    "job_matches": [
        {"role": "Role Name", "match_percentage": 0-100}
    ],
    "recommendation": "Brief recommendation (strengths & weaknesses)"
}

Ensure the output is ONLY the JSON object. Do not include markdown formatting or extra text.
PROMPT;
    }

    protected function fallbackResponse(string $text): array
    {
        return [
            'name' => 'Unknown (AI Fallback)',
            'email' => 'unknown@example.com',
            'phone' => null,
            'summary' => 'AI analysis failed or key missing. This is a fallback response.',
            'score' => 0,
            'skills' => [],
            'technical_skills' => [],
            'soft_skills' => [],
            'tools' => [],
            'in_demand_skills' => [],
            'job_matches' => [],
            'recommendation' => 'Manual review required as AI analysis could not be completed at this time.',
        ];
    }
}
