<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\AiKnowledge;
use App\Models\BioLink;
use App\Models\LinkClick;
use App\Models\PageView;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profile = $user->profile()->with(['theme', 'bioLinks', 'socialLinks'])->firstOrFail();

        // 1. Metric Counts & Comparisons
        $totalViews = PageView::where('profile_id', $profile->id)->count();
        $todayViews = PageView::where('profile_id', $profile->id)->whereDate('viewed_at', today())->count();
        $yesterdayViews = PageView::where('profile_id', $profile->id)->whereDate('viewed_at', today()->subDay())->count();
        
        $viewsDelta = $yesterdayViews > 0 
            ? round((($todayViews - $yesterdayViews) / $yesterdayViews) * 100, 1) 
            : ($todayViews > 0 ? 100 : 0);

        $totalClicks = BioLink::where('profile_id', $profile->id)->sum('total_clicks');
        $activeLinksCount = BioLink::where('profile_id', $profile->id)->where('is_active', true)->count();
        $clickRate = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;

        // 2. Top Performing Links with Percentage Share
        $topLinks = BioLink::where('profile_id', $profile->id)
            ->orderByDesc('total_clicks')
            ->take(5)
            ->get()
            ->map(function ($link) use ($totalClicks) {
                $link->percentage = $totalClicks > 0 ? round(($link->total_clicks / $totalClicks) * 100) : 0;
                return $link;
            });

        // 3. 7-Day Traffic Trend with High/Low bounds for SVG Spline
        $recentDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $targetDate = now()->subDays($i);
            $date = $targetDate->format('Y-m-d');
            $dayName = $targetDate->locale('id')->isoFormat('ddd');
            $viewsCount = PageView::where('profile_id', $profile->id)
                ->whereDate('viewed_at', $date)
                ->count();
            
            $recentDays->push([
                'date' => $date,
                'label' => $dayName,
                'full_date' => $targetDate->format('d M'),
                'views' => $viewsCount,
            ]);
        }

        // Calculate smooth SVG points for Area Chart (Width: 500, Height: 140)
        $chartMax = max(5, $recentDays->max('views'));
        $chartPoints = [];
        $svgPolyPoints = [];
        $n = count($recentDays);
        $w = 500;
        $h = 130;
        $padX = 15;
        $padY = 15;
        $usableW = $w - ($padX * 2);
        $usableH = $h - ($padY * 2);

        foreach ($recentDays as $idx => $day) {
            $x = round($padX + ($idx * ($usableW / max(1, $n - 1))));
            $y = round($padY + ($usableH - (($day['views'] / $chartMax) * $usableH)));
            $chartPoints[] = ['x' => $x, 'y' => $y, 'views' => $day['views'], 'label' => $day['label'], 'date' => $day['full_date']];
            $svgPolyPoints[] = "{$x},{$y}";
        }

        // SVG Path definition
        $svgPointsStr = implode(' ', $svgPolyPoints);
        $svgAreaPath = "M {$svgPolyPoints[0]} L " . implode(' L ', array_slice($svgPolyPoints, 1)) . " L {$chartPoints[$n-1]['x']},{$h} L {$chartPoints[0]['x']},{$h} Z";

        // 4. Device Breakdown
        $deviceRaw = PageView::where('profile_id', $profile->id)
            ->selectRaw('device_type, count(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->all();

        $devicesTotal = array_sum($deviceRaw) ?: 1;
        $devices = [
            'mobile' => [
                'count' => $deviceRaw['mobile'] ?? 0,
                'percentage' => round((($deviceRaw['mobile'] ?? 0) / $devicesTotal) * 100),
            ],
            'desktop' => [
                'count' => $deviceRaw['desktop'] ?? 0,
                'percentage' => round((($deviceRaw['desktop'] ?? 0) / $devicesTotal) * 100),
            ],
            'tablet' => [
                'count' => $deviceRaw['tablet'] ?? 0,
                'percentage' => round((($deviceRaw['tablet'] ?? 0) / $devicesTotal) * 100),
            ],
        ];

        // 5. Top Traffic Referrers
        $referrers = PageView::where('profile_id', $profile->id)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->selectRaw('referer, count(*) as count')
            ->groupBy('referer')
            ->orderByDesc('count')
            ->take(4)
            ->get();

        // 6. AI Assistant Readiness & Knowledge Stats
        $aiKnowledgeCount = AiKnowledge::where('profile_id', $profile->id)->count();

        // 7. Profile Completeness Calculation (Gamified onboarding progress)
        $score = 0;
        if (!empty($profile->avatar_url)) $score += 20;
        if (!empty($profile->bio)) $score += 15;
        if ($profile->socialLinks()->where('is_active', true)->exists()) $score += 15;
        if ($profile->bioLinks()->where('is_active', true)->exists()) $score += 20;
        if ($profile->theme_id) $score += 15;
        if ($user->hasTwoFactorEnabled()) $score += 15;
        $profileCompleteness = min(100, $score);

        return view('admin.dashboard', [
            'profile' => $profile,
            'user' => $user,
            'totalViews' => $totalViews,
            'todayViews' => $todayViews,
            'viewsDelta' => $viewsDelta,
            'totalClicks' => $totalClicks,
            'activeLinksCount' => $activeLinksCount,
            'clickRate' => $clickRate,
            'topLinks' => $topLinks,
            'recentDays' => $recentDays,
            'chartPoints' => $chartPoints,
            'svgAreaPath' => $svgAreaPath,
            'devices' => $devices,
            'referrers' => $referrers,
            'aiKnowledgeCount' => $aiKnowledgeCount,
            'profileCompleteness' => $profileCompleteness,
        ]);
    }
}
