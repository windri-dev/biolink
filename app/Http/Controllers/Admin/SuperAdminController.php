<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\BioLink;
use App\Models\LinkClick;
use App\Models\PageView;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminController
{
    /**
     * Master Control Dashboard Overview
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $usersQuery = User::with([
            'profile.bioLinks',
            'profile.socialLinks',
            'profile.theme',
        ])->withCount(['profile as bio_links_count' => function ($q) {
            // Count total links via profile
        }]);

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function ($pq) use ($search) {
                      $pq->where('handle', 'like', "%{$search}%")
                         ->orWhere('bio', 'like', "%{$search}%")
                         ->orWhere('display_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($status && in_array($status, ['active', 'suspended'])) {
            $usersQuery->where('status', $status);
        }

        $users = $usersQuery->latest()->paginate(15)->withQueryString();

        // Platform-wide Metrics
        $totalUsers = User::count();
        $totalLinks = BioLink::count();
        $totalViews = PageView::count();
        $totalClicks = LinkClick::count();
        $suspendedUsersCount = User::where('status', 'suspended')->count();

        // Recent Link Feed (What are users linking to?)
        $recentLinks = BioLink::with('profile.user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.master-control.index', [
            'users' => $users,
            'recentLinks' => $recentLinks,
            'totalUsers' => $totalUsers,
            'totalLinks' => $totalLinks,
            'totalViews' => $totalViews,
            'totalClicks' => $totalClicks,
            'suspendedUsersCount' => $suspendedUsersCount,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * Audit All Links Across Platform (Spam & Phishing Discovery)
     */
    public function links(Request $request): View
    {
        $search = $request->query('search');

        $linksQuery = BioLink::with('profile.user');

        if ($search) {
            $linksQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%")
                  ->orWhereHas('profile', function ($pq) use ($search) {
                      $pq->where('handle', 'like', "%{$search}%")
                         ->orWhere('display_name', 'like', "%{$search}%");
                  });
            });
        }

        $links = $linksQuery->latest()->paginate(25)->withQueryString();

        return view('admin.master-control.links', [
            'links' => $links,
            'search' => $search,
        ]);
    }

    /**
     * Inspect Single User Data in Detail (JSON API for Quick Modal)
     */
    public function showUser(int $id): JsonResponse
    {
        $user = User::with([
            'profile.bioLinks',
            'profile.socialLinks',
            'profile.aiKnowledges',
            'profile.theme',
        ])->findOrFail($id);

        $profile = $user->profile;

        $links = $profile ? $profile->bioLinks->map(function ($l) {
            return [
                'id' => $l->id,
                'title' => $l->title,
                'url' => $l->url,
                'click_count' => $l->click_count,
                'is_active' => (bool) $l->is_active,
                'created_at' => $l->created_at?->format('d M Y H:i'),
            ];
        }) : [];

        $knowledges = $profile ? $profile->aiKnowledges->map(function ($k) {
            return [
                'category' => $k->category,
                'title' => $k->title,
                'content' => $k->content,
            ];
        }) : [];

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'is_super_admin' => (bool) $user->is_super_admin,
                'created_at' => $user->created_at?->format('d M Y H:i'),
            ],
            'profile' => $profile ? [
                'handle' => $profile->handle,
                'display_name' => $profile->display_name,
                'avatar_url' => $profile->avatar_url,
                'bio' => $profile->bio,
                'total_views' => $profile->total_views,
                'ai_provider' => $profile->ai_provider,
                'ai_assistant_enabled' => (bool) $profile->ai_assistant_enabled,
            ] : null,
            'links' => $links,
            'knowledges' => $knowledges,
        ]);
    }

    /**
     * Toggle User Suspension (Active <-> Suspended)
     */
    public function toggleUserStatus(int $id, Request $request): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()?->id) {
            return back()->with('error', 'Anda tidak dapat menangguhkan akun Anda sendiri.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        $msg = $newStatus === 'suspended' 
            ? "Pengguna {$user->name} (@{$user->profile?->handle}) berhasil DITANGGUHKAN."
            : "Pengguna {$user->name} (@{$user->profile?->handle}) berhasil DIAKTIFKAN kembali.";

        return back()->with('success', $msg);
    }

    /**
     * Disable/Enable Abusive Link
     */
    public function toggleLinkStatus(int $id): RedirectResponse
    {
        $link = BioLink::findOrFail($id);
        $link->update(['is_active' => !$link->is_active]);

        $statusText = $link->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Tautan '{$link->title}' berhasil {$statusText}.");
    }

    /**
     * Delete an Abusive Link
     */
    public function destroyLink(int $id): RedirectResponse
    {
        $link = BioLink::findOrFail($id);
        $title = $link->title;
        $link->delete();

        return back()->with('success', "Tautan '{$title}' telah dihapus oleh Super Admin.");
    }

    /**
     * Delete User Account and Cascade Records
     */
    public function destroyUser(int $id, Request $request): RedirectResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()?->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Pengguna {$name} dan seluruh data tautannya berhasil dihapus.");
    }
}
