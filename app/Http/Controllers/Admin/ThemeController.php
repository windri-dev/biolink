<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ThemeController
{
    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    public function index(): View
    {
        $profile = $this->getProfile()->load('theme');
        $themes = Theme::orderBy('is_preset', 'desc')->get();

        return view('admin.themes.index', [
            'profile' => $profile,
            'currentTheme' => $profile->theme,
            'themes' => $themes,
        ]);
    }

    public function apply(Request $request, int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $theme = Theme::findOrFail($id);

        $profile->update(['theme_id' => $theme->id]);

        return redirect()->route('admin.themes.index')->with('success', "Tema '{$theme->name}' berhasil diterapkan!");
    }

    public function storeCustom(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'background_type' => 'required|string|in:gradient,solid,glassmorphism,image',
            'background_value' => 'nullable|string',
            'bg_image_file' => 'nullable|image|max:10240', // Max 10MB
            'bg_image_url' => 'nullable|string|max:2048',
            'bg_image_overlay' => 'nullable|numeric|min:0|max:100',
            'card_bg' => 'required|string',
            'card_border' => 'required|string',
            'card_text' => 'nullable|string',
            'card_hover_bg' => 'nullable|string',
            'text_color' => 'required|string',
            'subtext_color' => 'required|string',
            'accent_color' => 'required|string',
            'font_family' => 'nullable|string|max:100',
            'button_shape' => 'required|string|in:rounded-none,rounded-lg,rounded-xl,rounded-2xl,rounded-full',
        ]);

        // Process background image upload or URL if background_type is 'image'
        if ($validated['background_type'] === 'image') {
            $overlay = isset($validated['bg_image_overlay']) ? (floatval($validated['bg_image_overlay']) / 100) : 0.5;
            $overlayCss = "linear-gradient(rgba(0, 0, 0, {$overlay}), rgba(0, 0, 0, {$overlay}))";

            if ($request->hasFile('bg_image_file')) {
                $path = $request->file('bg_image_file')->store('themes', 'public');
                $imageUrl = '/storage/' . $path;
                $validated['background_value'] = "{$overlayCss}, url('{$imageUrl}')";
            } elseif (!empty($validated['bg_image_url'])) {
                $imageUrl = $validated['bg_image_url'];
                $validated['background_value'] = "{$overlayCss}, url('{$imageUrl}')";
            } else {
                $validated['background_value'] = $request->input('background_value') ?: '#09090b';
            }
        }

        if (empty($validated['background_value'])) {
            $validated['background_value'] = '#09090b';
        }

        // Clean extra input keys before saving to Theme model
        unset($validated['bg_image_file'], $validated['bg_image_url'], $validated['bg_image_overlay']);

        $themeName = !empty($validated['name']) ? $validated['name'] : 'Tema Kustom (' . $profile->display_name . ')';
        $currentTheme = $profile->theme;

        // If the current theme is an existing custom theme owned by this profile, update it
        if ($currentTheme && !$currentTheme->is_preset && str_ends_with($currentTheme->slug, '-' . $profile->id)) {
            $currentTheme->update([
                ...$validated,
                'name' => $themeName,
                'card_text' => $validated['card_text'] ?? $validated['text_color'],
                'card_hover_bg' => $validated['card_hover_bg'] ?? $validated['card_bg'],
                'font_family' => $validated['font_family'] ?? 'Plus Jakarta Sans, sans-serif',
            ]);
            $theme = $currentTheme;
        } else {
            $slug = 'custom-' . time() . '-' . $profile->id;
            $theme = Theme::create([
                ...$validated,
                'name' => $themeName,
                'slug' => $slug,
                'card_text' => $validated['card_text'] ?? $validated['text_color'],
                'card_hover_bg' => $validated['card_hover_bg'] ?? $validated['card_bg'],
                'font_family' => $validated['font_family'] ?? 'Plus Jakarta Sans, sans-serif',
                'is_preset' => false,
                'is_dark' => true,
            ]);
            $profile->update(['theme_id' => $theme->id]);
        }

        return redirect()->route('admin.themes.index')->with('success', 'Tema kustom berhasil disimpan dan diterapkan!');
    }

    public function resetBackground(): RedirectResponse
    {
        $profile = $this->getProfile();
        $currentTheme = $profile->theme;

        if ($currentTheme && !$currentTheme->is_preset) {
            $currentTheme->update([
                'background_type' => 'gradient',
                'background_value' => 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%)',
            ]);
        } else {
            $defaultTheme = Theme::where('is_preset', true)->first();
            $profile->update(['theme_id' => $defaultTheme?->id]);
        }

        return redirect()->route('admin.themes.index')->with('success', 'Gambar latar belakang berhasil dihapus dan dikembalikan ke gradient default.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $profile = $this->getProfile();
        $theme = Theme::findOrFail($id);

        if ($theme->is_preset) {
            return redirect()->route('admin.themes.index')->with('error', 'Tema preset bawaan tidak dapat dihapus.');
        }

        if ($profile->theme_id === $theme->id) {
            $defaultTheme = Theme::where('is_preset', true)->first();
            $profile->update(['theme_id' => $defaultTheme?->id]);
        }

        $theme->delete();

        return redirect()->route('admin.themes.index')->with('success', "Tema kustom '{$theme->name}' berhasil dihapus.");
    }
}
