<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiChatController
{
    public function __construct(
        protected AiAssistantService $aiService
    ) {}

    /**
     * Handle incoming visitor chat message
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string|max:64',
        ]);

        $profile = Profile::findOrFail($validated['profile_id']);

        if (!$profile->ai_assistant_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'AI Assistant saat ini dinonaktifkan oleh pemilik profil.',
            ], 403);
        }

        $result = $this->aiService->generateResponse(
            $profile,
            $validated['message'],
            $validated['session_id'],
            $request->ip()
        );

        return response()->json($result);
    }
}
