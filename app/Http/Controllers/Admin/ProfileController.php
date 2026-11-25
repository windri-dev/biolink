<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController
{
    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    public function index(): View
    {
        $profile = $this->getProfile()->load('socialLinks');
        $socialLinks = $profile->socialLinks;

        return view('admin.profile.index', [
            'profile' => $profile,
            'socialLinks' => $socialLinks,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'handle' => 'required|string|min:3|max:30|regex:/^[a-zA-Z0-9_-]+$/|unique:profiles,handle,' . $profile->id,
            'tagline' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'verified_title' => 'nullable|string|max:64',
            'badge_style' => 'nullable|string|max:32',
            'avatar_file' => 'nullable|image|max:5120', // 5MB
            'is_verified' => 'nullable|boolean',
            'show_share_button' => 'nullable|boolean',
            'ai_assistant_enabled' => 'nullable|boolean',
            'ai_assistant_name' => 'nullable|string|max:64',
            'ai_greeting_message' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'custom_css' => 'nullable|string|max:5000',
        ]);

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $validated['avatar_url'] = '/storage/' . $path;
        }

        $validated['is_verified'] = $request->boolean('is_verified');
        $validated['show_share_button'] = $request->boolean('show_share_button');
        $validated['ai_assistant_enabled'] = $request->boolean('ai_assistant_enabled');
        $validated['handle'] = strtolower($validated['handle']);

        $profile->update($validated);

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateSocials(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $socials = $request->input('socials', []);

        foreach ($socials as $platform => $data) {
            $url = trim($data['url'] ?? '');
            $isActive = !empty($data['is_active']);

            if (!empty($url)) {
                SocialLink::updateOrCreate(
                    [
                        'profile_id' => $profile->id,
                        'platform' => $platform,
                    ],
                    [
                        'url' => $url,
                        'label' => ucfirst($platform),
                        'is_active' => $isActive,
                        'sort_order' => (int) ($data['sort_order'] ?? 0),
                    ]
                );
            } else {
                SocialLink::where('profile_id', $profile->id)
                    ->where('platform', $platform)
                    ->delete();
            }
        }

        return redirect()->route('admin.profile.index')->with('success', 'Akun media sosial berhasil disinkronkan!');
    }
}
