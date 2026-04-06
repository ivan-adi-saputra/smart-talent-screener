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

    public function answerQuestion(Candidate $candidate, string $message, ?int $parentId = null): Chat
    {
        $context = $candidate->raw_text ?? '';

        // If parentId is provided, we can fetch previous messages for better context
        // For MVP, we'll just prepend the parent message/response if it exists
        if ($parentId) {
            $parent = Chat::find($parentId);
            if ($parent) {
                $context .= "\n\nPrevious Conversation:\nUser: {$parent->message}\nAI: {$parent->response}";
            }
        }
        
        $response = $this->geminiAi->chat($context, $message);

        return Chat::create([
            'candidate_id' => $candidate->id,
            'parent_id' => $parentId,
            'message' => $message,
            'response' => $response,
        ]);
    }
}
