<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AiChatController
{
    public function __construct(
        protected AiAssistantService $aiService
    ) {}

    /**
     * Handle incoming visitor chat message with per-IP rate limiting protection
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

        $ip = $request->ip() ?: '127.0.0.1';

        // Check if the request is from the authenticated owner testing in the dashboard simulator
        $isOwner = Auth::check() && Auth::user()->profile?->id === $profile->id;

        if (!$isOwner) {
            $minuteKey = 'ai-chat-minute:' . $ip;
            $hourKey = 'ai-chat-hour:' . $ip;

            // Maximum 10 messages per minute per IP
            if (RateLimiter::tooManyAttempts($minuteKey, 10)) {
                $seconds = RateLimiter::availableIn($minuteKey);
                return response()->json([
                    'success' => false,
                    'message' => "Terlalu banyak pesan dalam waktu singkat dari IP Anda. Demi mencegah spam dan pengurasan kuota token, mohon tunggu {$seconds} detik sebelum bertanya lagi.",
                ], 429);
            }

            // Maximum 60 messages per hour per IP
            if (RateLimiter::tooManyAttempts($hourKey, 60)) {
                $minutes = (int) ceil(RateLimiter::availableIn($hourKey) / 60);
                return response()->json([
                    'success' => false,
                    'message' => "Batas maksimal pesan per jam telah tercapai. Silakan coba kembali dalam {$minutes} menit.",
                ], 429);
            }

            RateLimiter::hit($minuteKey, 60);
            RateLimiter::hit($hourKey, 3600);
        }

        $result = $this->aiService->generateResponse(
            $profile,
            $validated['message'],
            $validated['session_id'],
            $ip
        );

        return response()->json($result);
    }
}
