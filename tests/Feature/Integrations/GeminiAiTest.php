<?php

use App\Integrations\GeminiAI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

it('parses real gemini response correctly', function () {
    Config::set('services.gemini.key', 'test-key');

    $mockResponse = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        [
                            'text' => json_encode([
                                'name' => 'Jane Smith',
                                'email' => 'jane@example.com',
                                'score' => 95,
                                'summary' => 'Expert React developer',
                                'skills' => ['React', 'JavaScript'],
                                'recommendation' => [
                                    'strengths' => ['Exp'],
                                    'weaknesses' => [],
                                    'suggestions' => []
                                ],
                                'cv_recommendation' => [
                                    'good_points' => ['Clear'],
                                    'improvement_points' => []
                                ]
                            ])
                        ]
                    ]
                ]
            ]
        ]
    ];

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    $gemini = new GeminiAI();
    $result = $gemini->analyzeCandidate('Sample CV text');

    expect($result)->toBeArray()
        ->and($result['name'])->toBe('Jane Smith')
        ->and($result['score'])->toBe(95);
});

it('throws exception on api failure', function () {
    Config::set('services.gemini.key', 'test-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response('Error', 500),
    ]);

    $gemini = new GeminiAI();
    $gemini->analyzeCandidate('Sample CV text');
})->throws(Exception::class);

it('throws exception when api key is missing', function () {
    Config::set('services.gemini.key', null);

    $gemini = new GeminiAI();
    $gemini->analyzeCandidate('Sample CV text');
})->throws(Exception::class);
