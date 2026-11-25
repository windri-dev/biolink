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

    <span class="text-xs md:text-sm font-semibold text-sky-400 tracking-wide mb-2 block">
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
                    <i data-lucide="map-pin" class="w-3 h-3 text-red-400"></i>
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
                        <i data-lucide="github" class="w-4 h-4"></i>
                    @elseif($soc->platform === 'telegram')
                        <i data-lucide="send" class="w-4 h-4 text-sky-400"></i>
                    @elseif($soc->platform === 'whatsapp')
                        <i data-lucide="message-circle" class="w-4 h-4 text-emerald-400"></i>
                    @elseif($soc->platform === 'email')
                        <i data-lucide="mail" class="w-4 h-4 text-amber-300"></i>
                    @elseif($soc->platform === 'youtube')
                        <i data-lucide="youtube" class="w-4 h-4 text-red-500"></i>
                    @elseif($soc->platform === 'twitter' || $soc->platform === 'x')
                        <i data-lucide="twitter" class="w-4 h-4"></i>
                    @elseif($soc->platform === 'linkedin')
                        <i data-lucide="linkedin" class="w-4 h-4 text-blue-400"></i>
                    @else
                        <i data-lucide="globe" class="w-4 h-4 text-zinc-300"></i>
                    @endif
                </a>
            @endforeach
        </div>
    @endif

    <!-- Bio Links Stack -->
    <div class="w-full space-y-3.5 mb-10">
        @forelse($links as $link)
            @if($link->type === 'header')
                <!-- Section Header Divider -->
                <div class="pt-4 pb-1 text-left">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-zinc-400/80 px-2 flex items-center gap-2">
                        <span>{{ $link->title }}</span>
                        <div class="flex-grow h-px bg-white/10"></div>
                    </h3>
                </div>
            @elseif($link->type === 'embed_youtube' && $link->url)
                <!-- YouTube Embed Video Card -->
                <div class="bio-card rounded-2xl p-3 text-left overflow-hidden">
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
                   class="bio-card {{ $theme->button_shape ?? 'rounded-2xl' }} p-4 flex items-center justify-between gap-3 group relative overflow-hidden {{ $link->is_highlighted ? 'anim-pulse ring-1 ring-sky-400/30' : '' }}">
                    
                    <div class="flex items-center gap-3.5 min-w-0 text-left">
                        <!-- Icon or Thumbnail -->
                        <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center flex-shrink-0 text-white transition-colors group-hover:bg-white/20">
                            @if($link->icon === 'shopping-bag')
                                <i data-lucide="shopping-bag" class="w-5 h-5 text-emerald-400"></i>
                            @elseif($link->icon === 'github')
                                <i data-lucide="github" class="w-5 h-5 text-zinc-200"></i>
                            @elseif($link->icon === 'sparkles')
                                <i data-lucide="sparkles" class="w-5 h-5 text-amber-400"></i>
                            @elseif($link->icon === 'send')
                                <i data-lucide="send" class="w-5 h-5 text-sky-400"></i>
                            @elseif($link->icon === 'code')
                                <i data-lucide="code-2" class="w-5 h-5 text-indigo-400"></i>
                            @else
                                <i data-lucide="external-link" class="w-5 h-5 text-zinc-300"></i>
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

                    <!-- Right Chevron Icon -->
                    <div class="p-1.5 rounded-lg text-white/30 group-hover:text-white group-hover:translate-x-1 transition-all flex-shrink-0">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </div>
                </a>
            @endif
        @empty
            <div class="py-12 text-zinc-500 text-sm">
                Belum ada tautan yang ditambahkan.
            </div>
        @endforelse
    </div>

</div>
@endsection
