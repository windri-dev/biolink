<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController
{
    public function index(): View
    {
        $profile = Profile::with('theme')->firstOrFail();
        $themes = Theme::orderBy('is_preset', 'desc')->get();

        return view('admin.themes.index', [
            'profile' => $profile,
            'currentTheme' => $profile->theme,
            'themes' => $themes,
        ]);
    }

    public function apply(Request $request, int $id): RedirectResponse
    {
        $profile = Profile::firstOrFail();
        $theme = Theme::findOrFail($id);

        $profile->update(['theme_id' => $theme->id]);

        return redirect()->route('admin.themes.index')->with('success', "Tema '{$theme->name}' berhasil diterapkan!");
    }

    public function storeCustom(Request $request): RedirectResponse
    {
        $profile = Profile::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'background_type' => 'required|string|in:gradient,solid,glassmorphism',
            'background_value' => 'required|string',
            'card_bg' => 'required|string',
            'card_border' => 'required|string',
            'card_text' => 'required|string',
            'text_color' => 'required|string',
            'subtext_color' => 'required|string',
            'accent_color' => 'required|string',
            'button_shape' => 'required|string|in:rounded-lg,rounded-2xl,rounded-full',
        ]);

        $slug = 'custom-' . time();

        $theme = Theme::create([
            ...$validated,
            'slug' => $slug,
            'is_preset' => false,
            'is_dark' => true,
        ]);

        $profile->update(['theme_id' => $theme->id]);

        return redirect()->route('admin.themes.index')->with('success', 'Tema kustom berhasil dibuat dan diterapkan!');
    }
}
