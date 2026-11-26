<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CvController
{
    /**
     * Display public Curriculum Vitae (CV / Resume) for a profile handle
     */
    public function show(string $handle, Request $request): View|RedirectResponse
    {
        $cleanHandle = strtolower(ltrim($handle, '@'));

        $profile = Profile::with(['theme', 'activeSocialLinks', 'user'])
            ->where('handle', $cleanHandle)
            ->firstOrFail();

        if ($profile->user && $profile->user->isSuspended()) {
            return view('public.suspended', [
                'profile' => $profile,
            ]);
        }

        if (!$profile->enable_cv) {
            // If visitor is the profile owner, allow previewing with alert, else redirect to bio
            if (!auth()->check() || auth()->id() !== $profile->user_id) {
                return redirect()->route('public.bio.at', $profile->clean_handle)
                    ->with('info', 'Curriculum Vitae untuk profil ini sedang dinonaktifkan.');
            }
        }

        // If experiences or skills are empty, we provide the preset as fallback preview so it looks great
        $experiences = $profile->cv_experiences ?? Profile::getDefaultCvPreset()['cv_experiences'];
        $educations = $profile->cv_educations ?? Profile::getDefaultCvPreset()['cv_educations'];
        $skills = $profile->cv_skills ?? Profile::getDefaultCvPreset()['cv_skills'];

        return view('public.cv', [
            'profile' => $profile,
            'theme' => $profile->theme,
            'socialLinks' => $profile->activeSocialLinks,
            'experiences' => $experiences,
            'educations' => $educations,
            'skills' => $skills,
        ]);
    }
}
