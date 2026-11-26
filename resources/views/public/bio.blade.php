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
                    <x-social-icon :platform="$soc->platform" class="w-5 h-5" />
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
