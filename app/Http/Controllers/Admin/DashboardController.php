<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

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
        $profile = Auth::user()->profile()->with(['theme', 'bioLinks', 'socialLinks'])->firstOrFail();

        // 1. Metric Counts
        $totalViews = PageView::where('profile_id', $profile->id)->count();
        $totalClicks = BioLink::where('profile_id', $profile->id)->sum('total_clicks');
        $activeLinksCount = BioLink::where('profile_id', $profile->id)->where('is_active', true)->count();
        $clickRate = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;

        // 2. Top Performing Links
        $topLinks = BioLink::where('profile_id', $profile->id)
            ->orderByDesc('total_clicks')
            ->take(5)
            ->get();

        // 3. Recent 7 Days Traffic
        $recentDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->locale('id')->isoFormat('ddd');
            $viewsCount = PageView::where('profile_id', $profile->id)
                ->whereDate('viewed_at', $date)
                ->count();
            $recentDays->push([
                'date' => $date,
                'label' => $dayName,
                'views' => $viewsCount,
            ]);
        }

        // 4. Device Breakdown
        $devices = PageView::where('profile_id', $profile->id)
            ->selectRaw('device_type, count(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->all();

        return view('admin.dashboard', [
            'profile' => $profile,
            'totalViews' => $totalViews,
            'totalClicks' => $totalClicks,
            'activeLinksCount' => $activeLinksCount,
            'clickRate' => $clickRate,
            'topLinks' => $topLinks,
            'recentDays' => $recentDays,
            'devices' => $devices,
        ]);
    }
}
