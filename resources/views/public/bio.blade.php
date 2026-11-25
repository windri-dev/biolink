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
                   class="p-2.5 rounded-full bg-white/5 hover:bg-white/15 border border-white/10 hover:border-white/30 text-white/80 hover:text-white transition-all hover:scale-110 shadow-sm"
                   title="{{ $soc->label ?: ucfirst($soc->platform) }}">
                    @if($soc->platform === 'github')
                        <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>
                    @elseif($soc->platform === 'instagram')
                        <svg class="w-4 h-4 text-pink-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                        </svg>
                    @elseif($soc->platform === 'tiktok')
                        <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    @elseif($soc->platform === 'telegram')
                        <svg class="w-4 h-4 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                        </svg>
                    @elseif($soc->platform === 'whatsapp')
                        <svg class="w-4 h-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/>
                        </svg>
                    @elseif($soc->platform === 'discord')
                        <svg class="w-4 h-4 text-indigo-400 fill-current" viewBox="0 0 24 24">
                            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                        </svg>
                    @elseif($soc->platform === 'facebook')
                        <svg class="w-4 h-4 text-blue-500 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    @elseif($soc->platform === 'spotify')
                        <svg class="w-4 h-4 text-emerald-400 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                        </svg>
                    @elseif($soc->platform === 'email')
                        <svg class="w-4 h-4 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    @elseif($soc->platform === 'youtube')
                        <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/>
                        </svg>
                    @elseif($soc->platform === 'twitter' || $soc->platform === 'x' || $soc->platform === 'threads')
                        <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    @elseif($soc->platform === 'linkedin')
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-zinc-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
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
