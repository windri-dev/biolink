<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') • BioLink</title>

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
            color: #f4f4f5;
        }
        .admin-nav-item.active {
            background-color: rgba(56, 189, 248, 0.12);
            color: #38bdf8;
            border-left: 3px solid #38bdf8;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 antialiased">

    <!-- Top Navbar -->
    <header class="h-16 border-b border-zinc-800/80 bg-zinc-900/50 backdrop-blur-md sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-black text-lg tracking-tight text-white">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-sky-400 to-indigo-600 flex items-center justify-center text-white shadow-md">
                    <i data-lucide="link-2" class="w-4 h-4"></i>
                </div>
                <span>BioLink<span class="text-sky-400">.</span></span>
            </a>
            <span class="text-[11px] font-mono uppercase bg-zinc-800 text-zinc-400 px-2 py-0.5 rounded border border-zinc-700">Studio</span>
        </div>

        <div class="flex items-center gap-3">
            <!-- View Public Profile Button -->
            @php
                $userHandle = auth()->user()->profile->clean_handle ?? 'windri';
            @endphp
            <a href="{{ route('public.bio.at', $userHandle) }}" target="_blank" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-200 transition-colors inline-flex items-center gap-1.5 border border-zinc-700">
                <span>Lihat Bio ({{ '@' . $userHandle }})</span>
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-zinc-400"></i>
            </a>

            <!-- Logout Form -->
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="p-2 rounded-lg text-zinc-400 hover:text-red-400 hover:bg-zinc-800 transition-colors" title="Keluar">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </header>

    <div class="flex-grow flex flex-col md:flex-row max-w-7xl w-full mx-auto px-4 sm:px-8 py-6 gap-6">

        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-60 flex-shrink-0">
            <nav class="bg-zinc-900/60 border border-zinc-800/80 rounded-2xl p-2.5 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>Ringkasan</span>
                </a>
                <a href="{{ route('admin.links.index') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.links.*') ? 'active' : '' }}">
                    <i data-lucide="link" class="w-4 h-4"></i>
                    <span>Kelola Tautan</span>
                </a>
                <a href="{{ route('admin.profile.index') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span>Profil & Medsos</span>
                </a>
                <a href="{{ route('admin.themes.index') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.themes.*') ? 'active' : '' }}">
                    <i data-lucide="palette" class="w-4 h-4"></i>
                    <span>Tema & Tampilan</span>
                </a>
                <a href="{{ route('admin.ai-knowledge.index') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.ai-knowledge.*') ? 'active' : '' }}">
                    <i data-lucide="brain-circuit" class="w-4 h-4"></i>
                    <span>Otak AI Assistant</span>
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="admin-nav-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-zinc-300 hover:text-white hover:bg-zinc-800/60 transition-colors {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                    <span>Statistik & Log</span>
                </a>
            </nav>
        </aside>

        <!-- Main Workspace Area -->
        <main class="flex-grow min-w-0">
            <!-- Flash Message Banner -->
            @if(session('success'))
                <div class="mb-5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-xs font-medium flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="mb-5 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-xs font-medium flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span>{{ session('error') ?: $errors->first() }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
