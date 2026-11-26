<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Response;

class SitemapController
{
    /**
     * Generate dynamic XML sitemap for search engines
     */
    public function index(): Response
    {
        $profiles = Profile::select(['handle', 'enable_cv', 'updated_at'])->orderByDesc('updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Homepage
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . url('/') . "</loc>\n";
        $xml .= '    <changefreq>daily</changefreq>' . "\n";
        $xml .= "    <priority>1.0</priority>\n";
        $xml .= "  </url>\n";

        // All Profile Pages
        foreach ($profiles as $prof) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . url('/@' . $prof->clean_handle) . "</loc>\n";
            $xml .= '    <lastmod>' . $prof->updated_at->toAtomString() . "</lastmod>\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";

            if ($prof->enable_cv) {
                $xml .= "  <url>\n";
                $xml .= '    <loc>' . url('/@' . $prof->clean_handle . '/cv') . "</loc>\n";
                $xml .= '    <lastmod>' . $prof->updated_at->toAtomString() . "</lastmod>\n";
                $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                $xml .= "    <priority>0.7</priority>\n";
                $xml .= "  </url>\n";
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
