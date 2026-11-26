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
     * Display public bio page for a handle (e.g. @windri, @budi, @shoppe)
     */
    public function show(string $handle, Request $request): View
    {
        $cleanHandle = strtolower(ltrim($handle, '@'));

        $profile = Profile::with(['theme', 'activeSocialLinks', 'activeBioLinks', 'user'])
            ->where('handle', $cleanHandle)
            ->first();

        if (!$profile) {
            abort(404, "Profil @{$cleanHandle} belum terdaftar.");
        }

        if ($profile->user && $profile->user->isSuspended()) {
            return view('public.suspended', [
                'profile' => $profile,
            ]);
        }

        $profile->syncCvBioLink();

        // Record page view silently
        try {
            $this->analyticsService->recordPageView($profile, $request);
        } catch (\Throwable $e) {
            // Do not block page rendering
        }

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
