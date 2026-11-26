@extends('layouts.public')

@section('content')
<div class="w-full flex flex-col items-center text-center">

    <!-- Avatar Container -->
    <div class="relative group mb-4">
        <div class="w-24 h-24 md:w-28 md:h-28 rounded-full p-1 bg-gradient-to-tr from-sky-400 via-indigo-500 to-purple-500 shadow-xl transition-transform duration-300 group-hover:scale-105">
            <img src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300' }}" 
                 alt="{{ $profile->display_name }}" 
                 class="w-full h-full object-cover rounded-full bg-zinc-900 border-2 border-zinc-900">
        </div>

        @if($profile->is_verified)
            <div class="absolute bottom-1 right-1 bg-sky-500 text-white p-1 rounded-full border-2 border-zinc-950 shadow-md" title="{{ $profile->verified_title }}">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
        @endif
    </div>

    <!-- Name & Handle -->
    <div class="flex items-center gap-2 justify-center mb-1">
        <h1 class="text-xl md:text-2xl font-extrabold tracking-tight text-white flex items-center gap-1.5">
            {{ $profile->display_name }}
        </h1>
    </div>

    <span class="text-xs md:text-sm font-semibold text-sky-400 tracking-wide mb-2 block font-mono">
        {{ '@' . $profile->clean_handle }}
    </span>

    <!-- Tagline & Location -->
    @if($profile->tagline || $profile->location)
        <div class="flex items-center justify-center flex-wrap gap-2 text-xs text-zinc-400 mb-3">
            @if($profile->tagline)
                <span>{{ $profile->tagline }}</span>
            @endif
            @if($profile->tagline && $profile->location)
                <span>&bull;</span>
            @endif
            @if($profile->location)
                <span class="inline-flex items-center gap-1">
                    <svg class="w-3 h-3 text-red-400 inline flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $profile->location }}
                </span>
            @endif
        </div>
    @endif

    <!-- Bio Description -->
    @if($profile->bio)
        <p class="text-sm text-zinc-300/90 max-w-md mx-auto leading-relaxed mb-6 font-normal">
            {{ $profile->bio }}
        </p>
    @endif

    <!-- Social Links Bar -->
    @if($socialLinks->isNotEmpty())
        <div class="flex items-center justify-center flex-wrap gap-3 mb-8">
            @foreach($socialLinks as $soc)
                <a href="{{ $soc->url }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/15 border border-white/10 hover:border-white/30 flex items-center justify-center transition-all hover:scale-110 shadow-sm"
                   title="{{ $soc->label ?: ucfirst($soc->platform) }}">
                    @if($soc->platform === 'github')
                        <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                    @elseif($soc->platform === 'instagram')
                        <svg class="w-5 h-5 text-pink-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    @elseif($soc->platform === 'tiktok')
                        <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    @elseif($soc->platform === 'telegram')
                        <svg class="w-5 h-5 text-sky-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.458c.538-.196 1.006.128.832.915z"/>
                        </svg>
                    @elseif($soc->platform === 'whatsapp')
                        <svg class="w-5 h-5 text-emerald-400 fill-current" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.301-.15-1.781-.878-2.056-.979-.275-.1-.475-.15-.675.15-.2.301-.776.979-.951 1.18-.175.2-.35.226-.651.075-.301-.15-1.272-.469-2.424-1.496-.895-.798-1.5-1.784-1.675-2.085-.175-.301-.019-.464.132-.614.136-.135.301-.35.451-.526.15-.175.2-.301.301-.501.1-.2.05-.376-.025-.526-.075-.15-.675-1.628-.925-2.231-.244-.588-.493-.508-.675-.517-.175-.01-.375-.01-.576-.01-.2 0-.526.075-.802.376-.275.301-1.052 1.028-1.052 2.508s1.077 2.909 1.228 3.11c.15.2 2.12 3.238 5.136 4.542.717.311 1.277.496 1.713.635.72.229 1.376.197 1.895.119.579-.087 1.781-.728 2.032-1.431.25-.702.25-1.303.175-1.43-.075-.126-.275-.201-.576-.351zm-5.467 7.618h-.002a10.948 10.948 0 0 1-5.586-1.531l-.401-.238-4.156 1.09 1.109-4.052-.261-.415A10.957 10.957 0 0 1 1.01 11.002C1.01 4.936 5.946 0 12.005 0c2.936 0 5.696 1.144 7.771 3.22a10.923 10.923 0 0 1 3.224 7.78c0 6.069-4.938 11.002-10.995 11.002z"/>
                        </svg>
                    @elseif($soc->platform === 'discord')
                        <svg class="w-5 h-5 text-indigo-400 fill-current" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                        </svg>
                    @elseif($soc->platform === 'facebook')
                        <svg class="w-5 h-5 text-blue-500 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    @elseif($soc->platform === 'spotify')
                        <svg class="w-5 h-5 text-emerald-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                    @elseif($soc->platform === 'email')
                        <svg class="w-5 h-5 text-amber-300 fill-current" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    @elseif($soc->platform === 'youtube')
                        <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    @elseif($soc->platform === 'twitter' || $soc->platform === 'x' || $soc->platform === 'threads')
                        <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    @elseif($soc->platform === 'linkedin')
                        <svg class="w-5 h-5 text-blue-400 fill-current" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-sky-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    <!-- Professional Curriculum Vitae (CV) Card Banner -->
    @if($profile->enable_cv)
        <a href="{{ route('public.cv', $profile->clean_handle) }}" 
           class="w-full bio-card {{ $theme->button_shape ?? 'rounded-2xl' }} p-4 mb-4 flex items-center justify-between gap-3 group relative overflow-hidden border border-sky-500/30 bg-gradient-to-r from-sky-500/10 via-indigo-500/10 to-transparent hover:border-sky-400/50 transition-all hover:scale-[1.01] shadow-lg text-left">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-sky-500/20 border border-sky-400/30 flex items-center justify-center flex-shrink-0 text-sky-400 group-hover:bg-sky-500/30 transition-colors">
                    <svg class="w-5 h-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-bold text-sm tracking-tight text-white group-hover:text-sky-300 transition-colors">
                            Curriculum Vitae & Riwayat Karir
                        </span>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full tracking-wider bg-sky-500/20 text-sky-300 border border-sky-500/30">
                            RESUME
                        </span>
                    </div>
                    <p class="text-xs text-zinc-300/80 mt-0.5 truncate font-normal">
                        {{ $profile->cv_headline ?: $profile->tagline ?: 'Lihat riwayat karir, keahlian teknis & portofolio resmi' }}
                    </p>
                </div>
            </div>
            <div class="p-1.5 rounded-lg text-sky-400/50 group-hover:text-sky-300 group-hover:translate-x-1 transition-all flex-shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </div>
        </a>
    @endif

    <!-- Bio Links Stack (Modular Bento Grid Supported) -->
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-10 text-left">
        @forelse($links as $link)
            @php
                $colSpan = ($link->card_size === 'half') ? 'sm:col-span-1' : 'col-span-full';
            @endphp

            @if($link->type === 'header')
                <!-- Section Header Divider (Full width) -->
                <div class="col-span-full pt-4 pb-1 text-left">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-zinc-400/80 px-2 flex items-center gap-2">
                        <span>{{ $link->title }}</span>
                        <div class="flex-grow h-px bg-white/10"></div>
                    </h3>
                </div>
            @elseif($link->type === 'embed_youtube' && $link->url)
                <!-- YouTube Embed Video Card -->
                <div class="{{ $colSpan }} bio-card rounded-2xl p-3 overflow-hidden">
                    <p class="text-xs font-semibold text-zinc-300 mb-2 px-1 flex items-center gap-1.5">
                        <i data-lucide="youtube" class="w-3.5 h-3.5 text-red-500"></i>
                        {{ $link->title }}
                    </p>
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-black/50">
                        @php
                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $link->url, $matches);
                            $ytId = $matches[1] ?? null;
                        @endphp
                        @if($ytId)
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" frameborder="0" allowfullscreen loading="lazy"></iframe>
                        @endif
                    </div>
                </div>
            @else
                <!-- Clickable Bio Link Button Card -->
                <a href="{{ route('public.click', $link->id) }}" 
                   {{ $link->open_in_new_tab ? 'target="_blank"' : '' }} 
                   rel="noopener noreferrer"
                   class="{{ $colSpan }} bio-card {{ $theme->button_shape ?? 'rounded-2xl' }} p-4 flex items-center justify-between gap-3 group relative overflow-hidden {{ $link->is_highlighted ? 'anim-pulse ring-1 ring-sky-400/30' : '' }}">
                    
                    <div class="flex items-center gap-3.5 min-w-0">
                        <!-- Icon or Thumbnail (Direct Native SVG) -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0 text-white transition-colors group-hover:bg-white/20">
                            @if($link->icon === 'shopping-bag')
                                <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                                </svg>
                            @elseif($link->icon === 'github')
                                <svg class="w-5 h-5 fill-current text-zinc-100" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                                </svg>
                            @elseif($link->icon === 'sparkles')
                                <svg class="w-5 h-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                                </svg>
                            @elseif($link->icon === 'send')
                                <svg class="w-5 h-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                                </svg>
                            @elseif($link->icon === 'code')
                                <svg class="w-5 h-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Title & Subtitle -->
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-sm tracking-tight text-white group-hover:text-sky-300 transition-colors">
                                    {{ $link->title }}
                                </span>
                                @if($link->badge_text)
                                    <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full tracking-wider
                                        {{ $link->badge_color === 'emerald' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : '' }}
                                        {{ $link->badge_color === 'sky' ? 'bg-sky-500/20 text-sky-300 border border-sky-500/30' : '' }}
                                        {{ $link->badge_color === 'amber' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : '' }}
                                        {{ $link->badge_color === 'purple' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : '' }}
                                        {{ !in_array($link->badge_color, ['emerald', 'sky', 'amber', 'purple']) ? 'bg-white/20 text-white border border-white/20' : '' }}">
                                        {{ $link->badge_text }}
                                    </span>
                                @endif
                            </div>
                            @if($link->subtitle)
                                <p class="text-xs text-zinc-400 mt-0.5 truncate font-normal">
                                    {{ $link->subtitle }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Right Chevron Icon SVG -->
                    <div class="p-1.5 rounded-lg text-white/30 group-hover:text-white group-hover:translate-x-1 transition-all flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </div>
                </a>
            @endif
        @empty
            <div class="col-span-full py-12 text-zinc-500 text-sm text-center">
                Belum ada tautan yang ditambahkan.
            </div>
        @endforelse
    </div>

</div>
@endsection
