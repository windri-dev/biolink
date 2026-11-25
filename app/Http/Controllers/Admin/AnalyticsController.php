<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\AiChat;
use App\Models\BioLink;
use App\Models\LinkClick;
use App\Models\PageView;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AnalyticsController
{
    public function index(): View
    {
        $profile = Auth::user()->profile()->firstOrFail();

        $totalViews = PageView::where('profile_id', $profile->id)->count();
        $totalClicks = BioLink::where('profile_id', $profile->id)->sum('total_clicks');
        $totalAiChats = AiChat::where('profile_id', $profile->id)->count();

        // 14 Days daily traffic trend
        $trafficTrend = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d M');
            $views = PageView::where('profile_id', $profile->id)->whereDate('viewed_at', $date)->count();
            $trafficTrend->push([
                'date' => $date,
                'label' => $label,
                'views' => $views,
            ]);
        }

        // Links performance list
        $linksStats = BioLink::where('profile_id', $profile->id)
            ->withCount('clicks')
            ->orderByDesc('total_clicks')
            ->get();

        // Device breakdown
        $devices = PageView::where('profile_id', $profile->id)
            ->selectRaw('device_type, count(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->all();

        // GEO Countries Breakdown
        $countries = PageView::where('profile_id', $profile->id)
            ->whereNotNull('country_name')
            ->selectRaw('country_code, country_name, count(*) as count')
            ->groupBy('country_code', 'country_name')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        // Top Referrers
        $referrers = PageView::where('profile_id', $profile->id)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->selectRaw('referer, count(*) as count')
            ->groupBy('referer')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        // Recent AI Chat logs
        $recentChats = AiChat::where('profile_id', $profile->id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.analytics.index', [
            'profile' => $profile,
            'totalViews' => $totalViews,
            'totalClicks' => $totalClicks,
            'totalAiChats' => $totalAiChats,
            'trafficTrend' => $trafficTrend,
            'linksStats' => $linksStats,
            'devices' => $devices,
            'countries' => $countries,
            'referrers' => $referrers,
            'recentChats' => $recentChats,
        ]);
    }
}
