<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Http\Requests\ChatRequest;
use App\Models\Candidate;
use App\Services\ChatService;
use App\Http\Resources\ChatResource;
use Exception;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ChatService $chatService
    ) {}

    public function store(ChatRequest $request): JsonResponse
    {
        try {
            $candidate = Candidate::findOrFail($request->candidate_id);
            $chat = $this->chatService->answerQuestion(
                $candidate, 
                $request->message, 
                $request->parent_id
            );

            return $this->success(
                new ChatResource($chat),
                'Chat response generated'
            );
        } catch (Exception $e) {
            return $this->error('Failed to generate chat response: ' . $e->getMessage(), $e->getCode(), [], true, 60);
        }
    }
}
