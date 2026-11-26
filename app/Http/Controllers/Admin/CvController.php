<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CvController
{
    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    /**
     * Display CV management page
     */
    public function index(): View
    {
        $profile = $this->getProfile();

        // If newly opened and CV fields are empty, prepare default preset preview
        $preset = Profile::getDefaultCvPreset();
        $experiences = $profile->cv_experiences ?? $preset['cv_experiences'];
        $educations = $profile->cv_educations ?? $preset['cv_educations'];
        $skills = $profile->cv_skills ?? $preset['cv_skills'];

        return view('admin.cv.index', [
            'profile' => $profile,
            'experiences' => $experiences,
            'educations' => $educations,
            'skills' => $skills,
        ]);
    }

    /**
     * Save CV details, experiences, educations, and skills
     */
    public function update(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();

        $validated = $request->validate([
            'cv_headline' => 'nullable|string|max:255',
            'cv_summary' => 'nullable|string|max:3000',
            'cv_template' => 'nullable|string|in:modern,minimal,executive',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:10240', // 10MB
            'experiences' => 'nullable|array',
            'experiences.*.company' => 'nullable|string|max:255',
            'experiences.*.role' => 'nullable|string|max:255',
            'experiences.*.period' => 'nullable|string|max:100',
            'experiences.*.location' => 'nullable|string|max:255',
            'experiences.*.description' => 'nullable|string|max:3000',
            'educations' => 'nullable|array',
            'educations.*.school' => 'nullable|string|max:255',
            'educations.*.degree' => 'nullable|string|max:255',
            'educations.*.field_of_study' => 'nullable|string|max:255',
            'educations.*.period' => 'nullable|string|max:100',
            'educations.*.gpa' => 'nullable|string|max:50',
            'educations.*.description' => 'nullable|string|max:1500',
            'skills_raw' => 'nullable|string',
        ]);

        $data = [
            'enable_cv' => $request->boolean('enable_cv'),
            'cv_headline' => $validated['cv_headline'] ?? $profile->tagline,
            'cv_summary' => $validated['cv_summary'] ?? null,
            'cv_template' => $validated['cv_template'] ?? 'modern',
        ];

        // Process experiences
        if (isset($validated['experiences']) && is_array($validated['experiences'])) {
            $filteredExperiences = [];
            foreach ($validated['experiences'] as $exp) {
                if (!empty($exp['company']) || !empty($exp['role'])) {
                    $filteredExperiences[] = [
                        'company' => trim((string)($exp['company'] ?? '')),
                        'role' => trim((string)($exp['role'] ?? '')),
                        'period' => trim((string)($exp['period'] ?? '')),
                        'location' => trim((string)($exp['location'] ?? '')),
                        'description' => trim((string)($exp['description'] ?? '')),
                    ];
                }
            }
            $data['cv_experiences'] = $filteredExperiences;
        }

        // Process educations
        if (isset($validated['educations']) && is_array($validated['educations'])) {
            $filteredEducations = [];
            foreach ($validated['educations'] as $edu) {
                if (!empty($edu['school']) || !empty($edu['degree'])) {
                    $filteredEducations[] = [
                        'school' => trim((string)($edu['school'] ?? '')),
                        'degree' => trim((string)($edu['degree'] ?? '')),
                        'field_of_study' => trim((string)($edu['field_of_study'] ?? '')),
                        'period' => trim((string)($edu['period'] ?? '')),
                        'gpa' => trim((string)($edu['gpa'] ?? '')),
                        'description' => trim((string)($edu['description'] ?? '')),
                    ];
                }
            }
            $data['cv_educations'] = $filteredEducations;
        }

        // Process Skills (Parsed from raw multiline or JSON)
        if ($request->filled('skills_raw')) {
            $skillsRaw = $request->input('skills_raw');
            $parsedSkills = [];
            
            // Format support:
            // Kategori: Skill 1, Skill 2, Skill 3
            $lines = explode("\n", str_replace("\r", "", $skillsRaw));
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                if (str_contains($line, ':')) {
                    [$cat, $items] = explode(':', $line, 2);
                    $cat = trim($cat);
                    $skillsList = array_values(array_filter(array_map('trim', explode(',', $items))));
                    if (!empty($skillsList)) {
                        $parsedSkills[$cat] = $skillsList;
                    }
                } else {
                    $skillsList = array_values(array_filter(array_map('trim', explode(',', $line))));
                    if (!empty($skillsList)) {
                        $parsedSkills['Keahlian Umum'] = array_merge($parsedSkills['Keahlian Umum'] ?? [], $skillsList);
                    }
                }
            }
            $data['cv_skills'] = !empty($parsedSkills) ? $parsedSkills : null;
        }

        // Upload custom CV document (PDF/DOCX)
        if ($request->hasFile('cv_file')) {
            // Delete old file if exists
            if ($profile->cv_file_url && str_starts_with($profile->cv_file_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $profile->cv_file_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('cv_file')->store('cvs', 'public');
            $data['cv_file_url'] = '/storage/' . $path;
        }

        $profile->update($data);

        return redirect()->route('admin.cv.index')->with('success', 'Curriculum Vitae berhasil diperbarui!');
    }

    /**
     * Quick toggle CV active / inactive
     */
    public function toggle(Request $request): RedirectResponse
    {
        $profile = $this->getProfile();
        $newState = !$profile->enable_cv;
        $profile->update(['enable_cv' => $newState]);

        $statusText = $newState ? 'diaktifkan dan dapat diakses publik.' : 'dinonaktifkan (tersembunyi dari publik).';
        return back()->with('success', "Curriculum Vitae (CV) berhasil {$statusText}");
    }

    /**
     * 1-Click Load standard professional CV preset template
     */
    public function loadTemplate(): RedirectResponse
    {
        $profile = $this->getProfile();
        $preset = Profile::getDefaultCvPreset();

        $profile->update([
            'enable_cv' => true,
            'cv_headline' => $preset['cv_headline'],
            'cv_summary' => $preset['cv_summary'],
            'cv_template' => $preset['cv_template'],
            'cv_skills' => $preset['cv_skills'],
            'cv_experiences' => $preset['cv_experiences'],
            'cv_educations' => $preset['cv_educations'],
        ]);

        return redirect()->route('admin.cv.index')->with('success', '✨ Templet CV Profesional Siap Pakai berhasil dimuat ke profil Anda!');
    }

    /**
     * Delete uploaded CV document file
     */
    public function deleteFile(): RedirectResponse
    {
        $profile = $this->getProfile();

        if ($profile->cv_file_url && str_starts_with($profile->cv_file_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $profile->cv_file_url);
            Storage::disk('public')->delete($oldPath);
        }

        $profile->update(['cv_file_url' => null]);

        return redirect()->route('admin.cv.index')->with('success', 'File CV custom berhasil dihapus.');
    }
}
