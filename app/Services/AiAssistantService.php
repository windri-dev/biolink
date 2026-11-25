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
            $greetingResponse = "Halo! Senang bertemu dengan Anda. Saya {$profile->ai_assistant_name}, asisten virtual cerdas untuk {$profile->display_name}. Silakan tanyakan apa saja tentang proyek, latar belakang keahlian, atau cara berkolaborasi! ✨";

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

        // 4. If OPENAI_API_KEY is configured, forward to OpenAI LLM with grounded profile context
        $apiKey = config('services.openai.api_key') ?? env('OPENAI_API_KEY');
        if (!empty($apiKey)) {
            try {
                $llmResponse = $this->queryOpenAi($profile, $knowledges, $messageClean, $apiKey);
                if ($llmResponse) {
                    $this->logChat($profile->id, $sessionId, $userMessage, $llmResponse, 'openai_llm', $ipAddress);

                    return [
                        'success' => true,
                        'response' => $llmResponse,
                        'matched_intent' => 'openai_llm',
                        'suggested_prompts' => $this->getSuggestedPrompts($knowledges),
                    ];
                }
            } catch (\Throwable $e) {
                Log::warning('OpenAI AI Assistant call failed: ' . $e->getMessage());
            }
        }

        // 5. Graceful Local Fallback Response
        $fallback = "Terima kasih pertanyaannya! Informasi spesifik mengenai hal tersebut belum tercatat di data pengetahuan saya. Namun Anda bisa langsung menghubungi {$profile->display_name} melalui tautan kontak Telegram atau WhatsApp di profil ini agar dibalas langsung! 🚀";

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
     * Query external OpenAI API if key provided
     */
    protected function queryOpenAi(Profile $profile, Collection $knowledges, string $userMessage, string $apiKey): ?string
    {
        $context = "Anda adalah asisten AI ramah bernama {$profile->ai_assistant_name} untuk {$profile->display_name} ({$profile->tagline}). Berikut data pengetahuan resmi yang Anda ketahui:\n";
        foreach ($knowledges as $k) {
            $context .= "- {$k->title}: {$k->content}\n";
        }
        $context .= "\nJawab pertanyaan pengunjung dengan ringkas, sopan, bersahabat dalam Bahasa Indonesia, dan mengacu pada data di atas.";

        $response = Http::withToken($apiKey)
            ->timeout(15)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    ['role' => 'system', 'content' => $context],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'max_tokens' => 350,
                'temperature' => 0.7,
            ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        }

        return null;
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
