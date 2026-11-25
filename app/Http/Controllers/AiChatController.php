<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class AiChatController
{
    public function __construct(
        protected AiAssistantService $aiService
    ) {}

    /**
     * Handle incoming visitor chat message with per-IP rate limiting & multi-layer AI security protection
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_id' => 'required|exists:profiles,id',
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string|max:64',
            'website_hp' => 'nullable|string|max:50', // Honeypot anti-bot
        ]);

        // 1. Honeypot check: If hidden field is filled, it's an automated spam bot
        if (!empty($validated['website_hp'])) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan ditolak oleh filter anti-bot otomatis.',
            ], 400);
        }

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

        // 2. Multi-Layer Rate Limiting & Cooldown Protection per IP
        if (!$isOwner) {
            $banKey = 'ai-chat-banned:' . $ip;
            if (RateLimiter::tooManyAttempts($banKey, 1)) {
                $banSeconds = RateLimiter::availableIn($banKey);
                $banMinutes = (int) ceil($banSeconds / 60);
                return response()->json([
                    'success' => false,
                    'message' => "IP Anda ({$ip}) sedang diblokir sementara ({$banMinutes} menit lagi) karena terdeteksi melakukan spam atau pelanggaran berulang.",
                ], 429);
            }

            $limitPerMinute = max(1, (int) ($profile->ai_rate_limit_per_minute ?: 10));
            $limitPerHour = max(5, (int) ($profile->ai_rate_limit_per_hour ?: 60));
            $blockDurationSeconds = max(60, ((int) ($profile->ai_block_duration_minutes ?: 15)) * 60);

            $minuteKey = 'ai-chat-minute:' . $ip;
            $hourKey = 'ai-chat-hour:' . $ip;
            $strikesKey = 'ai-chat-strikes:' . $ip;

            // Check per-minute rate limit
            if (RateLimiter::tooManyAttempts($minuteKey, $limitPerMinute)) {
                $seconds = RateLimiter::availableIn($minuteKey);
                RateLimiter::hit($strikesKey, 3600);
                
                // If strikes reach 4, trigger auto-ban
                if (RateLimiter::attempts($strikesKey) >= 4) {
                    RateLimiter::hit($banKey, $blockDurationSeconds);
                    Log::warning("AI Security: IP {$ip} auto-banned for {$blockDurationSeconds}s due to persistent spam.");
                }

                return response()->json([
                    'success' => false,
                    'message' => "Batas frekuensi pesan tercapai (Maks. {$limitPerMinute} pesan/menit). Mohon tunggu {$seconds} detik sebelum mengirim pesan kembali.",
                ], 429);
            }

            // Check per-hour rate limit
            if (RateLimiter::tooManyAttempts($hourKey, $limitPerHour)) {
                $minutes = (int) ceil(RateLimiter::availableIn($hourKey) / 60);
                RateLimiter::hit($banKey, $blockDurationSeconds);

                return response()->json([
                    'success' => false,
                    'message' => "Batas maksimal pesan per jam ({$limitPerHour} pesan) untuk IP Anda telah tercapai. Akses dibatasi selama {$minutes} menit.",
                ], 429);
            }

            RateLimiter::hit($minuteKey, 60);
            RateLimiter::hit($hourKey, 3600);
        }

        $userMessage = trim($validated['message']);

        // 3. AI Security Guard: Prompt Injection & Jailbreak Firewall
        if ($profile->ai_security_guard && $this->isPromptInjection($userMessage)) {
            Log::info("AI Security: Prompt Injection / Jailbreak attempt blocked from IP {$ip}: '{$userMessage}'");
            return response()->json([
                'success' => true,
                'response' => "🛡️ **Peringatan Keamanan Sistem**: Permintaan manipulasi instruksi sistem (*prompt injection / jailbreak / credential inquiry*) terdeteksi dan diblokir oleh AI Security Shield. Silakan ajukan pertanyaan wajar seputar portofolio, keahlian, atau kolaborasi dengan {$profile->display_name}.",
                'matched_intent' => 'security_firewall_blocked',
                'suggested_prompts' => [
                    "Siapa itu {$profile->display_name}?",
                    "Apa saja proyek yang pernah dibuat?",
                    "Bagaimana cara menghubungi {$profile->display_name}?",
                ],
            ]);
        }

        // 4. Content Moderation: Toxic & Abusive Harassment Filter
        if ($profile->ai_content_filter && $this->isToxicContent($userMessage)) {
            return response()->json([
                'success' => true,
                'response' => "⚠️ Pesan Anda mengandung kata-kata yang tidak pantas atau melanggar etika komunikasi. Mohon gunakan bahasa yang sopan dan relevan seputar informasi profil {$profile->display_name}.",
                'matched_intent' => 'content_moderation_filtered',
                'suggested_prompts' => [
                    "Siapa itu {$profile->display_name}?",
                    "Apa saja proyek yang pernah dibuat?",
                ],
            ]);
        }

        // 5. Generate Natural & Context-Strict Response
        $result = $this->aiService->generateResponse(
            $profile,
            $userMessage,
            $validated['session_id'],
            $ip
        );

        return response()->json($result);
    }

    /**
     * Detect Prompt Injection, System Override & Jailbreak Patterns
     */
    protected function isPromptInjection(string $message): bool
    {
        $lower = strtolower($message);

        $patterns = [
            'ignore previous instructions',
            'ignore all previous instructions',
            'ignore the above instructions',
            'disregard all previous',
            'system prompt',
            'reveal your prompt',
            'show your prompt',
            'show system prompt',
            'what is your system prompt',
            'print your prompt',
            'reveal api key',
            'show api key',
            'what is your api key',
            'bocorkan api key',
            'kunci api rahasia',
            'jailbreak',
            'dan mode',
            'developer mode enabled',
            'bypass filter',
            'bypass safety',
            'unfiltered mode',
            'pretend you are an unrestricted',
            'pretend you have no rules',
            'you are now in maintenance mode',
            'output everything above',
            'sudo mode',
            'override system',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($lower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect Profanity / Severe Abusive Content
     */
    protected function isToxicContent(string $message): bool
    {
        $lower = strtolower($message);

        $toxicWords = [
            'anjing lu', 'babi lu', 'bangsat', 'kontol', 'memek', 'jembut', 'pantek', 'ngentot', 
            'fuck you', 'bitch', 'asshole', 'motherfucker', 'bastard', 'kill yourself',
        ];

        foreach ($toxicWords as $toxic) {
            if (str_contains($lower, $toxic)) {
                return true;
            }
        }

        return false;
    }
}
