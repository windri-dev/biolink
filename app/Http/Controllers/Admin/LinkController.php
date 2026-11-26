<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\BioLink;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LinkController
{
    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    public function index(): View
    {
        $profile = $this->getProfile();
        $profile->syncCvBioLink();
        $links = BioLink::where('profile_id', $profile->id)->orderBy('sort_order')->get();

        return view('admin.links.index', [
            'profile' => $profile,
            'links' => $links,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:2048',
            'type' => 'required|string|in:link,header,embed_youtube,embed_spotify',
            'icon' => 'nullable|string|max:64',
            'card_size' => 'nullable|string|in:full,half,featured',
            'badge_text' => 'nullable|string|max:32',
            'badge_color' => 'nullable|string|max:32',
            'is_highlighted' => 'nullable|boolean',
            'animation_type' => 'nullable|string|max:32',
            'open_in_new_tab' => 'nullable|boolean',
        ]);

        $maxOrder = BioLink::where('profile_id', $profile->id)->max('sort_order') ?? 0;

        BioLink::create([
            'profile_id' => $profile->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'url' => $validated['url'] ?? null,
            'icon' => $validated['icon'] ?? 'link',
            'card_size' => $validated['card_size'] ?? 'full',
            'badge_text' => $validated['badge_text'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'emerald',
            'is_highlighted' => $request->boolean('is_highlighted'),
            'animation_type' => $validated['animation_type'] ?? 'none',
            'open_in_new_tab' => $request->boolean('open_in_new_tab', true),
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.links.index')->with('success', 'Tautan baru berhasil ditambahkan!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $link = BioLink::where('profile_id', $profile->id)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:2048',
            'type' => 'required|string|in:link,header,embed_youtube,embed_spotify',
            'icon' => 'nullable|string|max:64',
            'card_size' => 'nullable|string|in:full,half,featured',
            'badge_text' => 'nullable|string|max:32',
            'badge_color' => 'nullable|string|max:32',
            'is_highlighted' => 'nullable|boolean',
            'animation_type' => 'nullable|string|max:32',
            'open_in_new_tab' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $link->update([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'url' => $validated['url'] ?? null,
            'icon' => $validated['icon'] ?? $link->icon,
            'card_size' => $validated['card_size'] ?? $link->card_size ?? 'full',
            'badge_text' => $validated['badge_text'] ?? null,
            'badge_color' => $validated['badge_color'] ?? 'emerald',
            'is_highlighted' => $request->boolean('is_highlighted'),
            'animation_type' => $validated['animation_type'] ?? 'none',
            'open_in_new_tab' => $request->boolean('open_in_new_tab', true),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.links.index')->with('success', 'Tautan berhasil diperbarui!');
    }

    public function toggle(int $id): JsonResponse
    {
        $profile = $this->getProfile();
        $link = BioLink::where('profile_id', $profile->id)->findOrFail($id);
        $link->update(['is_active' => !$link->is_active]);

        if ($link->type === 'cv') {
            $profile->update(['enable_cv' => $link->is_active]);
        }

        return response()->json([
            'success' => true,
            'is_active' => $link->is_active,
            'message' => 'Status tautan berhasil diubah.',
        ]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $profile = $this->getProfile();

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->input('order') as $index => $id) {
            BioLink::where('profile_id', $profile->id)->where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan tautan berhasil disimpan.',
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $link = BioLink::where('profile_id', $profile->id)->findOrFail($id);
        $link->delete();

        return redirect()->route('admin.links.index')->with('success', 'Tautan berhasil dihapus.');
    }
}
