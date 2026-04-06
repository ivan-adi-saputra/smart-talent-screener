<?php

use App\Models\Candidate;
use App\Models\Chat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('services.gemini.key', 'test-key');
    Config::set('services.gemini.model', 'gemini-1.5-flash');
    Config::set('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta/models');
});

it('can generate a chatbot response and save it to the database', function () {
    $candidate = Candidate::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '08123456789',
        'summary' => 'Experienced software engineer.',
        'score' => 85,
        'raw_cv_path' => 'cv_uploads/test.pdf',
        'skills' => ['PHP', 'Laravel'],
        'technical_skills' => ['PHP', 'Laravel'],
        'soft_skills' => ['Communication'],
        'tools' => ['Git'],
        'in_demand_skills' => ['Laravel'],
        'job_matches' => [['role' => 'Backend Developer', 'match_percentage' => 90]],
        'recommendation' => ['strengths' => ['Exp'], 'weaknesses' => [], 'suggestions' => []],
        'cv_recommendation' => ['good_points' => ['Clear'], 'improvement_points' => []],
        'raw_text' => 'Experienced software engineer with skills in PHP and Laravel.',
    ]);

    $mockResponse = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        ['text' => 'John Doe has extensive experience in PHP and Laravel.']
                    ]
                ]
            ]
        ]
    ];

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    $response = $this->postJson('/api/chat', [
        'candidate_id' => $candidate->id,
        'message' => 'What are his core skills?',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'message' => 'Chat response generated',
            'data' => [
                'message' => 'What are his core skills?',
                'response' => 'John Doe has extensive experience in PHP and Laravel.',
            ],
        ]);

    $this->assertDatabaseHas('chats', [
        'candidate_id' => $candidate->id,
        'message' => 'What are his core skills?',
        'response' => 'John Doe has extensive experience in PHP and Laravel.',
    ]);
});

it('validates required fields for chat', function () {
    $response = $this->postJson('/api/chat', []);

    $response->assertStatus(422)
        ->assertJson([
            'status' => 'error',
        ])
        ->assertJsonFragment(['The candidate id field is required.'])
        ->assertJsonFragment(['The message field is required.']);
});

it('returns 404 if candidate does not exist', function () {
    $response = $this->postJson('/api/chat', [
        'candidate_id' => 999,
        'message' => 'Hello',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'status' => 'error',
        ])
        ->assertJsonFragment(['The selected candidate id is invalid.']);
});

it('can create a reply to an existing chat', function () {
    $candidate = Candidate::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '08123456789',
        'summary' => 'Experienced software engineer.',
        'score' => 85,
        'raw_cv_path' => 'cv_uploads/test.pdf',
        'skills' => ['PHP', 'Laravel'],
        'technical_skills' => ['PHP', 'Laravel'],
        'soft_skills' => ['Communication'],
        'tools' => ['Git'],
        'in_demand_skills' => ['Laravel'],
        'job_matches' => [['role' => 'Backend Developer', 'match_percentage' => 90]],
        'recommendation' => ['strengths' => ['Exp'], 'weaknesses' => [], 'suggestions' => []],
        'cv_recommendation' => ['good_points' => ['Clear'], 'improvement_points' => []],
        'raw_text' => 'Experienced software engineer with skills in PHP and Laravel.',
    ]);

    $parentChat = Chat::create([
        'candidate_id' => $candidate->id,
        'message' => 'First question',
        'response' => 'First answer',
    ]);

    $mockResponse = [
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        ['text' => 'This is a follow-up answer.']
                    ]
                ]
            ]
        ]
    ];

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response($mockResponse, 200),
    ]);

    $response = $this->postJson('/api/chat', [
        'candidate_id' => $candidate->id,
        'message' => 'Follow up question',
        'parent_id' => $parentChat->id,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'parent_id' => $parentChat->id,
                'message' => 'Follow up question',
                'response' => 'This is a follow-up answer.',
            ],
        ]);

    $this->assertDatabaseHas('chats', [
        'candidate_id' => $candidate->id,
        'parent_id' => $parentChat->id,
        'message' => 'Follow up question',
    ]);
});

it('validates that parent_id belongs to the same candidate', function () {
    $candidate1 = Candidate::create([
        'name' => 'John One',
        'email' => 'john1@example.com',
        'phone' => '08123456781',
        'summary' => 'Summary 1',
        'score' => 80,
        'raw_cv_path' => 'cv_uploads/1.pdf',
        'skills' => [],
        'technical_skills' => [],
        'soft_skills' => [],
        'tools' => [],
        'in_demand_skills' => [],
        'job_matches' => [],
        'recommendation' => [],
        'cv_recommendation' => [],
        'raw_text' => 'Text 1',
    ]);

    $candidate2 = Candidate::create([
        'name' => 'John Two',
        'email' => 'john2@example.com',
        'phone' => '08123456782',
        'summary' => 'Summary 2',
        'score' => 80,
        'raw_cv_path' => 'cv_uploads/2.pdf',
        'skills' => [],
        'technical_skills' => [],
        'soft_skills' => [],
        'tools' => [],
        'in_demand_skills' => [],
        'job_matches' => [],
        'recommendation' => [],
        'cv_recommendation' => [],
        'raw_text' => 'Text 2',
    ]);

    $parentChat = Chat::create([
        'candidate_id' => $candidate1->id,
        'message' => 'Question from 1',
        'response' => 'Answer for 1',
    ]);

    $response = $this->postJson('/api/chat', [
        'candidate_id' => $candidate2->id,
        'message' => 'Reply for 2 but using 1 as parent',
        'parent_id' => $parentChat->id,
    ]);

    $response->assertStatus(422)
        ->assertJsonFragment(['The parent chat must belong to the same candidate.']);
});
