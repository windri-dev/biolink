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
     * Record a public profile page view
     */
    public function recordPageView(Profile $profile, Request $request): PageView
    {
        $userAgent = $request->userAgent() ?? '';
        $deviceType = $this->detectDevice($userAgent);
        $browser = $this->detectBrowser($userAgent);
        $platform = $this->detectPlatform($userAgent);

        return PageView::create([
            'profile_id' => $profile->id,
            'ip_address' => $request->ip(),
            'user_agent' => substr($userAgent, 0, 500),
            'referer' => substr((string) $request->header('referer'), 0, 255),
            'device_type' => $deviceType,
            'browser' => $browser,
            'platform' => $platform,
            'viewed_at' => now(),
        ]);
    }

    /**
     * Record a link click
     */
    public function recordLinkClick(BioLink $link, Request $request): LinkClick
    {
        $userAgent = $request->userAgent() ?? '';
        $deviceType = $this->detectDevice($userAgent);

        $click = LinkClick::create([
            'bio_link_id' => $link->id,
            'ip_address' => $request->ip(),
            'user_agent' => substr($userAgent, 0, 500),
            'referer' => substr((string) $request->header('referer'), 0, 255),
            'device_type' => $deviceType,
            'clicked_at' => now(),
        ]);

        $link->recordClick();

        return $click;
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
