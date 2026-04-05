<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidate;

it('can analyze a cv file', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                [
                    'content' => [
                        'parts' => [
                            ['text' => json_encode([
                                'name' => 'John Doe',
                                'email' => 'john.doe@example.com',
                                'phone' => '+628123456789',
                                'summary' => 'Expert with fake data.',
                                'score' => 85,
                                'skills' => ['Test'],
                                'technical_skills' => ['PHP'],
                                'soft_skills' => ['Communication'],
                                'tools' => ['Git'],
                                'in_demand_skills' => ['AI'],
                                'job_matches' => [['role' => 'Dev', 'match_percentage' => 90]],
                                'recommendation' => 'Good candidate.'
                            ])]
                        ]
                    ]
                ]
            ]
        ], 200),
    ]);

    $response = $this->postJson('/api/analyze-cv', [
        'cv_file' => $file,
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'status',
                 'message',
                 'data' => [
                     'id',
                     'name',
                     'email',
                     'summary',
                     'score',
                     'skills',
                     'job_matches',
                 ],
             ]);

    $this->assertDatabaseHas('candidates', [
        'email' => 'john.doe@example.com', // Match with simulated data in GeminiAI
    ]);

    Storage::disk('public')->assertExists('cv_uploads/' . $file->hashName());
});

it('validates cv file upload', function () {
    $response = $this->postJson('/api/analyze-cv', []);

    $response->assertStatus(422)
             ->assertJson([
                 'status' => 'error',
                 'message' => 'The cv file field is required.',
             ]);
});
