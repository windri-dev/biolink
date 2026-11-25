<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiChat;
use App\Models\AiKnowledge;
use App\Models\Profile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistantService
{
    /**
     * Process visitor message and generate smart AI response
     */
    public function generateResponse(Profile $profile, string $userMessage, string $sessionId, ?string $ipAddress = null): array
    {
        $messageClean = trim($userMessage);
        $messageLower = strtolower($messageClean);

        // 1. Fetch active knowledge base for this profile
        $knowledges = $profile->activeAiKnowledges()->get();

        // 2. Check for Greetings
        if ($this->isGreeting($messageLower)) {
            $greetingResponse = "Halo, selamat datang. Saya {$profile->ai_assistant_name}, asisten virtual untuk {$profile->display_name}. Silakan tanyakan hal terkait proyek, keahlian teknis, atau jalur kolaborasi.";

            $this->logChat($profile->id, $sessionId, $userMessage, $greetingResponse, 'greeting', $ipAddress);

            return [
                'success' => true,
                'response' => $greetingResponse,
                'matched_intent' => 'greeting',
                'suggested_prompts' => $this->getSuggestedPrompts($knowledges),
            ];
        }

        // 3. Match against Knowledge Base (Weighted Keyword Scoring)
        $bestMatch = $this->findBestMatch($knowledges, $messageLower);

        if ($bestMatch) {
            $response = $bestMatch->content;

            $this->logChat($profile->id, $sessionId, $userMessage, $response, $bestMatch->category, $ipAddress);

            return [
                'success' => true,
                'response' => $response,
                'matched_intent' => $bestMatch->category,
                'knowledge_title' => $bestMatch->title,
                'suggested_prompts' => $this->getSuggestedPrompts($knowledges, $bestMatch->id),
            ];
        }

        // 4. If AI API Key is configured on the Profile (or system .env fallback), query the LLM API
        $apiKey = $profile->ai_api_key ?: config('services.openai.api_key') ?: env('OPENAI_API_KEY');
        if (!empty($apiKey) && in_array($profile->ai_provider, ['openai', 'custom'], true)) {
            try {
                $llmResponse = $this->queryLlmApi($profile, $knowledges, $messageClean, $apiKey);
                if ($llmResponse) {
                    $this->logChat($profile->id, $sessionId, $userMessage, $llmResponse, $profile->ai_provider . '_llm', $ipAddress);

                    return [
                        'success' => true,
                        'response' => $llmResponse,
                        'matched_intent' => $profile->ai_provider . '_llm',
                        'suggested_prompts' => $this->getSuggestedPrompts($knowledges),
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning('LLM AI Assistant call failed: ' . $e->getMessage());
            }
        }

        // 5. Graceful Local Fallback Response
        $fallback = "Terima kasih atas pertanyaannya. Informasi spesifik mengenai hal tersebut belum tercatat di data pengetahuan saya. Anda dapat menghubungi {$profile->display_name} secara langsung melalui tautan kontak Telegram atau Email pada profil ini.";

        $this->logChat($profile->id, $sessionId, $userMessage, $fallback, 'fallback', $ipAddress);

        return [
            'success' => true,
            'response' => $fallback,
            'matched_intent' => 'fallback',
            'suggested_prompts' => $this->getSuggestedPrompts($knowledges),
        ];
    }

    /**
     * Check if visitor message is a basic greeting
     */
    protected function isGreeting(string $msg): bool
    {
        $greetings = ['halo', 'hai', 'hello', 'hi', 'hei', 'pagi', 'siang', 'sore', 'malam', 'assalamualaikum', 'tes', 'ping'];
        foreach ($greetings as $greet) {
            if ($msg === $greet || str_starts_with($msg, $greet . ' ')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Match user query with knowledge items based on keyword scoring
     */
    protected function findBestMatch(Collection $knowledges, string $msg): ?AiKnowledge
    {
        $bestItem = null;
        $highestScore = 0;

        foreach ($knowledges as $item) {
            $score = 0;

            // Score based on Title
            $titleLower = strtolower($item->title);
            if (str_contains($msg, $titleLower)) {
                $score += 10;
            }

            // Score based on Keywords
            if (!empty($item->keywords)) {
                $keywords = array_map('trim', explode(',', strtolower($item->keywords)));
                foreach ($keywords as $kw) {
                    if (!empty($kw) && str_contains($msg, $kw)) {
                        $score += 5;
                    }
                }
            }

            // Substring words check
            $words = explode(' ', $msg);
            foreach ($words as $word) {
                if (strlen($word) >= 3 && str_contains(strtolower($item->content), $word)) {
                    $score += 1;
                }
            }

            if ($score > $highestScore && $score >= 5) {
                $highestScore = $score;
                $bestItem = $item;
            }
        }

        return $bestItem;
    }

    /**
     * Retrieve 3 suggested prompt chips
     */
    protected function getSuggestedPrompts(Collection $knowledges, ?int $excludeId = null): array
    {
        return $knowledges
            ->whereNotNull('suggested_prompt')
            ->when($excludeId, fn($c) => $c->where('id', '!=', $excludeId))
            ->pluck('suggested_prompt')
            ->take(3)
            ->values()
            ->all();
    }

    /**
     * Query external OpenAI or OpenAI-Compatible LLM API (DeepSeek, Groq, Ollama, OpenRouter)
     */
    public function queryLlmApi(Profile $profile, Collection $knowledges, string $userMessage, string $apiKey): ?string
    {
        $systemPrompt = $profile->ai_system_prompt;
        if (empty($systemPrompt)) {
            $systemPrompt = "Anda adalah asisten AI ramah bernama {$profile->ai_assistant_name} untuk {$profile->display_name} ({$profile->tagline}). Berikut data pengetahuan resmi yang Anda ketahui:\n";
            foreach ($knowledges as $k) {
                $systemPrompt .= "- {$k->title}: {$k->content}\n";
            }
            $systemPrompt .= "\nJawab pertanyaan pengunjung dengan ringkas, sopan, bersahabat dalam Bahasa Indonesia, dan mengacu pada data di atas tanpa menggunakan emoji berlebih.";
        }

        $apiBase = rtrim($profile->ai_api_base ?: 'https://api.openai.com/v1', '/');
        $endpoint = str_ends_with($apiBase, '/chat/completions') ? $apiBase : $apiBase . '/chat/completions';
        $model = $profile->ai_model ?: 'gpt-4o-mini';
        $temperature = (float) ($profile->ai_temperature ?: 0.7);

        $response = Http::withToken($apiKey)
            ->timeout(20)
            ->post($endpoint, [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'max_tokens' => 450,
                'temperature' => $temperature,
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        Log::warning('LLM API returned error: ' . $response->status() . ' - ' . $response->body());

        return null;
    }

    /**
     * Test connection to a custom AI API
     */
    public function testConnection(string $apiKey, string $apiBase, string $model): array
    {
        $apiBase = rtrim($apiBase ?: 'https://api.openai.com/v1', '/');
        $endpoint = str_ends_with($apiBase, '/chat/completions') ? $apiBase : $apiBase . '/chat/completions';

        try {
            $response = Http::withToken($apiKey)
                ->timeout(10)
                ->post($endpoint, [
                    'model' => $model ?: 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'user', 'content' => 'Tes koneksi API: balas kata OK.']
                    ],
                    'max_tokens' => 20,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Koneksi ke API AI berhasil! Model merespons: ' . trim((string) $response->json('choices.0.message.content')),
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal terhubung ke API (HTTP ' . $response->status() . '): ' . substr($response->body(), 0, 200),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Koneksi gagal: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Log conversation in database
     */
    protected function logChat(int $profileId, string $sessionId, string $message, string $response, string $intent, ?string $ip): void
    {
        try {
            AiChat::create([
                'profile_id' => $profileId,
                'session_id' => $sessionId,
                'user_message' => $message,
                'ai_response' => $response,
                'matched_intent' => $intent,
                'ip_address' => $ip,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log AI chat: ' . $e->getMessage());
        }
    }
}
