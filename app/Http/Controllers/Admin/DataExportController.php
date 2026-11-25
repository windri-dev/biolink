<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DataExportController
{
    protected function getProfile(): Profile
    {
        return Auth::user()->profile()->firstOrFail();
    }

    /**
     * Export complete profile & link collection as JSON
     */
    public function exportJson(): JsonResponse
    {
        $profile = $this->getProfile()->load(['bioLinks', 'socialLinks', 'aiKnowledges', 'theme']);

        $filename = "biolink_backup_{$profile->clean_handle}_" . date('Y-m-d') . ".json";

        return response()->json([
            'exported_at' => now()->toIso8601String(),
            'platform' => 'BioLink',
            'version' => '1.0.0',
            'profile' => [
                'display_name' => $profile->display_name,
                'handle' => $profile->handle,
                'bio' => $profile->bio,
                'tagline' => $profile->tagline,
                'location' => $profile->location,
                'phone' => $profile->phone,
                'meta_title' => $profile->meta_title,
                'meta_description' => $profile->meta_description,
                'custom_css' => $profile->custom_css,
            ],
            'social_links' => $profile->socialLinks,
            'bio_links' => $profile->bioLinks,
            'ai_knowledges' => $profile->aiKnowledges,
        ], 200, [
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export links as CSV
     */
    public function exportCsv(): Response
    {
        $profile = $this->getProfile();
        $links = $profile->bioLinks()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"biolink_links_{$profile->clean_handle}_" . date('Y-m-d') . ".csv\"",
        ];

        $handle = fopen('php://memory', 'r+');
        fputcsv($handle, ['ID', 'Tipe', 'Judul', 'Subjudul', 'URL', 'Badge', 'Ukuran Kartu', 'Total Klik', 'Status']);

        foreach ($links as $link) {
            fputcsv($handle, [
                $link->id,
                $link->type,
                $link->title,
                $link->subtitle ?? '',
                $link->url ?? '',
                $link->badge_text ?? '',
                $link->card_size,
                $link->total_clicks,
                $link->is_active ? 'Aktif' : 'Mati',
            ]);
        }

        rewind($handle);
        $csvOutput = stream_get_contents($handle);
        fclose($handle);

        return response($csvOutput, 200, $headers);
    }
}
