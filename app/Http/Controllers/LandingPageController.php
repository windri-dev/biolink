<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController
{
    public function index(): View
    {
        $featuredProfiles = Profile::with(['theme', 'activeBioLinks'])
            ->where('is_verified', true)
            ->take(6)
            ->get();

        $themes = Theme::where('is_preset', true)->take(6)->get();

        return view('landing', [
            'featuredProfiles' => $featuredProfiles,
            'themes' => $themes,
        ]);
    }
}
