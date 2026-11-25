<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BioLink;
use App\Models\Profile;
use App\Services\AnalyticsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBioController
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    /**
     * Display public bio page
     */
    public function show(?string $handle = null, Request $request): View
    {
        // 1. Resolve profile by handle (or fallback to the first/primary profile)
        $profile = null;
        if ($handle) {
            $cleanHandle = ltrim($handle, '@');
            $profile = Profile::with(['theme', 'activeSocialLinks', 'activeBioLinks'])
                ->where('handle', $cleanHandle)
                ->orWhere('handle', '@' . $cleanHandle)
                ->first();
        }

        if (!$profile) {
            $profile = Profile::with(['theme', 'activeSocialLinks', 'activeBioLinks'])->firstOrFail();
        }

        // 2. Record page view silently
        try {
            $this->analyticsService->recordPageView($profile, $request);
        } catch (\Throwable $e) {
            // Do not block page rendering if analytics fails
        }

        // 3. Render public bio template
        return view('public.bio', [
            'profile' => $profile,
            'theme' => $profile->theme,
            'socialLinks' => $profile->activeSocialLinks,
            'links' => $profile->activeBioLinks,
        ]);
    }

    /**
     * Redirect through click tracking endpoint /l/{id}
     */
    public function trackClick(int $id, Request $request): RedirectResponse
    {
        $link = BioLink::findOrFail($id);

        try {
            $this->analyticsService->recordLinkClick($link, $request);
        } catch (\Throwable $e) {
            //
        }

        return redirect()->away($link->url ?? '/');
    }
}
