<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\AiKnowledge;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AiKnowledgeController
{
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
