<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BioLink;
use App\Models\LinkClick;
use App\Models\PageView;
use App\Models\Profile;
use Illuminate\Http\Request;

class AnalyticsService
{
    /**
     * Record a public profile page view with Geo & Device data
     */
    public function recordPageView(Profile $profile, Request $request): PageView
    {
        $userAgent = $request->userAgent() ?? '';
        $deviceType = $this->detectDevice($userAgent);
        $browser = $this->detectBrowser($userAgent);
        $platform = $this->detectPlatform($userAgent);
        $geo = $this->resolveGeoLocation($request);

        return PageView::create([
            'profile_id' => $profile->id,
            'ip_address' => $request->ip(),
            'country_code' => $geo['country_code'],
            'country_name' => $geo['country_name'],
            'city' => $geo['city'],
            'user_agent' => substr($userAgent, 0, 500),
            'referer' => substr((string) $request->header('referer'), 0, 255),
            'device_type' => $deviceType,
            'browser' => $browser,
            'platform' => $platform,
            'viewed_at' => now(),
        ]);
    }

    /**
     * Record a link click with Geo data
     */
    public function recordLinkClick(BioLink $link, Request $request): LinkClick
    {
        $userAgent = $request->userAgent() ?? '';
        $deviceType = $this->detectDevice($userAgent);
        $geo = $this->resolveGeoLocation($request);

        $click = LinkClick::create([
            'bio_link_id' => $link->id,
            'ip_address' => $request->ip(),
            'country_code' => $geo['country_code'],
            'country_name' => $geo['country_name'],
            'city' => $geo['city'],
            'user_agent' => substr($userAgent, 0, 500),
            'referer' => substr((string) $request->header('referer'), 0, 255),
            'device_type' => $deviceType,
            'clicked_at' => now(),
        ]);

        $link->recordClick();

        return $click;
    }

    /**
     * Resolve GEO Location (Country code, country name, city)
     */
    public function resolveGeoLocation(Request $request): array
    {
        // 1. Cloudflare IPCountry header
        $countryCode = strtoupper((string) ($request->header('CF-IPCountry') ?? $request->header('X-Country-Code') ?? ''));

        // If local IP (private or loopback)
        $ip = $request->ip();
        if (empty($countryCode) || $countryCode === 'XX' || $countryCode === 'T1') {
            if ($ip === '127.0.0.1' || str_starts_with((string) $ip, '192.168.') || str_starts_with((string) $ip, '10.')) {
                return [
                    'country_code' => 'ID',
                    'country_name' => 'Indonesia (Local)',
                    'city' => 'Jakarta',
                ];
            }
            $countryCode = 'ID'; // Default fallback
        }

        $countryMap = [
            'ID' => 'Indonesia',
            'SG' => 'Singapore',
            'MY' => 'Malaysia',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'JP' => 'Japan',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'NL' => 'Netherlands',
            'IN' => 'India',
        ];

        return [
            'country_code' => substr($countryCode, 0, 4),
            'country_name' => $countryMap[$countryCode] ?? $countryCode,
            'city' => (string) ($request->header('CF-IPCity') ?? 'Direct Visitor'),
        ];
    }

    /**
     * Determine device type from user agent
     */
    public function detectDevice(string $ua): string
    {
        $uaLower = strtolower($ua);

        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $uaLower)) {
            return 'tablet';
        }

        if (preg_match('/(mobi|iphone|ipod|blackberry|iemobile|opera mini|webos)/i', $uaLower)) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Simple browser detector
     */
    public function detectBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg/')) return 'Edge';
        if (str_contains($ua, 'Chrome/')) return 'Chrome';
        if (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome/')) return 'Safari';
        if (str_contains($ua, 'Firefox/')) return 'Firefox';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR/')) return 'Opera';

        return 'Other';
    }

    /**
     * Simple platform / OS detector
     */
    public function detectPlatform(string $ua): string
    {
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) return 'iOS';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS X')) return 'macOS';
        if (str_contains($ua, 'Linux')) return 'Linux';

        return 'Other';
    }
}
