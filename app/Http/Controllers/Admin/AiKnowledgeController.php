<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\AiKnowledge;
use App\Models\Profile;
use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AiKnowledgeController
{
    public function __construct(
        protected AiAssistantService $aiService
    ) {}

    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    public function index(): View
    {
        $profile = $this->getProfile();
        $knowledges = AiKnowledge::where('profile_id', $profile->id)->orderBy('sort_order')->get();

        return view('admin.ai-knowledge.index', [
            'profile' => $profile,
            'knowledges' => $knowledges,
        ]);
    }

    /**
     * Update AI Assistant API Key, Base URL, Provider, Model & Prompt Settings
     */
    public function updateAiSettings(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'ai_provider' => 'nullable|string|max:50',
            'ai_api_key' => 'nullable|string|max:500',
            'ai_api_base' => 'nullable|string|max:500',
            'ai_model' => 'nullable|string|max:100',
            'ai_temperature' => 'nullable|numeric|min:0|max:2',
            'ai_system_prompt' => 'nullable|string|max:3000',
            'ai_assistant_name' => 'nullable|string|max:64',
            'ai_greeting_message' => 'nullable|string|max:500',
            'ai_assistant_enabled' => 'nullable|boolean',
        ]);

        $validated['ai_provider'] = $request->input('ai_provider') ?: 'universal';

        $validated['ai_assistant_enabled'] = $request->boolean('ai_assistant_enabled', true);
        if (empty($validated['ai_api_base'])) {
            $validated['ai_api_base'] = 'https://api.openai.com/v1';
        }
        if (empty($validated['ai_model'])) {
            $validated['ai_model'] = 'gpt-4o-mini';
        }

        $profile->update($validated);

        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Konfigurasi API AI Assistant berhasil disimpan!');
    }

    /**
     * Test connection to custom AI API directly from dashboard
     */
    public function testConnection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'api_key' => 'required|string',
            'api_base' => 'nullable|string',
            'model' => 'nullable|string',
        ]);

        $result = $this->aiService->testConnection(
            $validated['api_key'],
            $validated['api_base'] ?? 'https://api.openai.com/v1',
            $validated['model'] ?? 'gpt-4o-mini'
        );

        return response()->json($result);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'category' => 'required|string|in:bio,project,experience,contact,faq',
            'title' => 'required|string|max:255',
            'keywords' => 'nullable|string|max:500',
            'content' => 'required|string|max:5000',
            'suggested_prompt' => 'nullable|string|max:255',
        ]);

        $maxOrder = AiKnowledge::where('profile_id', $profile->id)->max('sort_order') ?? 0;

        AiKnowledge::create([
            'profile_id' => $profile->id,
            'category' => $validated['category'],
            'title' => $validated['title'],
            'keywords' => $validated['keywords'] ?? null,
            'content' => $validated['content'],
            'suggested_prompt' => $validated['suggested_prompt'] ?? null,
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Data pengetahuan AI berhasil ditambahkan!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $knowledge = AiKnowledge::where('profile_id', $profile->id)->findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|string|in:bio,project,experience,contact,faq',
            'title' => 'required|string|max:255',
            'keywords' => 'nullable|string|max:500',
            'content' => 'required|string|max:5000',
            'suggested_prompt' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $knowledge->update([
            'category' => $validated['category'],
            'title' => $validated['title'],
            'keywords' => $validated['keywords'] ?? null,
            'content' => $validated['content'],
            'suggested_prompt' => $validated['suggested_prompt'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Data pengetahuan AI berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $knowledge = AiKnowledge::where('profile_id', $profile->id)->findOrFail($id);
        $knowledge->delete();

        return redirect()->route('admin.ai-knowledge.index')->with('success', 'Data pengetahuan berhasil dihapus.');
    }
}
