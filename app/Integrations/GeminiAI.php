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
    protected string $url;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key') ?? '';
        $this->model = config('services.gemini.model');
        $this->baseUrl = config('services.gemini.base_url');
        $this->url = "{$this->baseUrl}/{$this->model}:generateContent";
    }

    public function chat(string $context, string $message): string
    {
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not set.');
        }

        try {
            $prompt = $this->getChatPrompt($context, $message);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->apiKey,
            ])
            ->post($this->url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                $errorMessage = $response->json()['error']['message'] ?? $response->body();
                throw new Exception("Gemini API request failed: " . $errorMessage);
            }

            $result = $response->json();
            $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$content) {
                throw new Exception("Invalid response format from Gemini API");
            }

            return $content;

        } catch (Exception $e) {
            Log::error('Gemini Chat Error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function getChatPrompt(string $context, string $message): string
    {
        return <<<PROMPT
You are an AI assistant helping a recruiter analyze a candidate's CV.
Use the following CV context to answer the user's question.
If the answer is not in the context, say that you don't have that information based on the CV.

CV CONTEXT:
{$context}

USER QUESTION:
{$message}

ANSWER:
PROMPT;
    }

    public function analyzeCandidate(string $text): array
    {
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not set.');
        }

        try {
            $prompt = $this->getPrompt($text);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->apiKey,
            ])
            ->post($this->url, [
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
                $errorMessage = $response->json()['error']['message'] ?? $response->body();
                throw new Exception("Gemini API request failed: " . $errorMessage);
            }

            $result = $response->json();
            $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$content) {
                throw new Exception("Invalid response format from Gemini API");
            }

            $decoded = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to decode Gemini AI response as JSON: " . json_last_error_msg());
            }

            return $decoded;

        } catch (Exception $e) {
            Log::error('Gemini Analysis Error: ' . $e->getMessage());
            throw $e; // Propagate exception to be handled by the controller
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
    "recommendation": {
        "strengths": ["Strength 1", "Strength 2"],
        "weaknesses": ["Weakness 1", "Weakness 2"],
        "suggestions": ["Suggestion 1", "Suggestion 2"]
    },
    "cv_recommendation": {
        "good_points": ["Point 1", "Point 2"],
        "improvement_points": ["Point 1", "Point 2"]
    }
}

Ensure the output is ONLY the JSON object. Do not include markdown formatting or extra text.
PROMPT;
    }
}
