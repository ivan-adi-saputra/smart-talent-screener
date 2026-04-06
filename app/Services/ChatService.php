<?php

namespace App\Services;

use App\Integrations\GeminiAI;
use App\Models\Candidate;
use App\Models\Chat;

class ChatService
{
    public function __construct(
        protected GeminiAI $geminiAi
    ) {}

    public function answerQuestion(Candidate $candidate, string $message): Chat
    {
        $context = $candidate->raw_text ?? '';
        
        $response = $this->geminiAi->chat($context, $message);

        return Chat::create([
            'candidate_id' => $candidate->id,
            'message' => $message,
            'response' => $response,
        ]);
    }
}
