@props([
    'profile',
    'experiences' => null,
    'educations' => null,
    'skills' => null,
    'socialLinks' => null,
    'compact' => false,
])

@php
    $experiences = $experiences ?? ($profile->cv_experiences ?? \App\Models\Profile::getDefaultCvPreset()['cv_experiences']);
    $educations = $educations ?? ($profile->cv_educations ?? \App\Models\Profile::getDefaultCvPreset()['cv_educations']);
    $skills = $skills ?? ($profile->cv_skills ?? \App\Models\Profile::getDefaultCvPreset()['cv_skills']);
    $socialLinks = $socialLinks ?? $profile->activeSocialLinks;
@endphp

<div class="cv-container cv-card rounded-3xl p-5 sm:p-8 md:p-10 shadow-2xl bg-[#121826]/75 border border-white/10 text-slate-100">
    
    <!-- CV Header: Profile, Name, Contact, & Socials -->
    <header class="flex flex-col md:flex-row items-center md:items-start gap-5 sm:gap-6 pb-6 sm:pb-8 border-b border-white/10 print-border-b">
        <!-- Avatar -->
        <div class="relative flex-shrink-0">
            <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 rounded-2xl overflow-hidden border-2 border-sky-400/30 p-1 bg-zinc-900/60 shadow-xl">
                <img src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300' }}" 
                     alt="{{ $profile->display_name }}" 
                     class="w-full h-full object-cover rounded-xl bg-zinc-950">
            </div>
            @if($profile->is_verified)
                <div class="absolute -bottom-1 -right-1 bg-sky-500 text-white p-1 rounded-lg border-2 border-zinc-950 shadow-md" title="{{ $profile->verified_title }}">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                </div>
            @endif
        </div>

        <!-- Identity & Contacts -->
        <div class="flex-grow text-center md:text-left space-y-2 min-w-0">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-tight text-white print-text-dark flex items-center justify-center md:justify-start gap-2 flex-wrap">
                        <span>{{ $profile->display_name }}</span>
                        <span class="no-print text-xs font-mono font-medium text-sky-400 px-2 py-0.5 rounded-full bg-sky-500/10 border border-sky-500/20">
                            {{ '@' . $profile->clean_handle }}
                        </span>
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base font-semibold text-sky-400 print-text-muted mt-1">
                        {{ $profile->cv_headline ?: $profile->tagline ?: ($profile->job_title . ' at ' . $profile->company) }}
                    </p>
                </div>
            </div>

            <!-- Contact & Meta Information Chips -->
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 sm:gap-2.5 pt-2 text-xs text-zinc-300 print-text-dark font-medium">
                @if($profile->location)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 print-badge">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-rose-400 flex-shrink-0"></i>
                        <span>{{ $profile->location }}</span>
                    </span>
                @endif

                @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 hover:border-sky-400/40 print-badge transition-colors">
                        <i data-lucide="phone" class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0"></i>
                        <span>{{ $profile->phone }}</span>
                    </a>
                @endif

                @if($profile->user && $profile->user->email)
                    <a href="mailto:{{ $profile->user->email }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 hover:border-sky-400/40 print-badge transition-colors">
                        <i data-lucide="mail" class="w-3.5 h-3.5 text-amber-400 flex-shrink-0"></i>
                        <span>{{ $profile->user->email }}</span>
                    </a>
                @endif

                <a href="{{ url('/@' . $profile->clean_handle) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 hover:border-sky-400/40 print-badge transition-colors font-mono">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-sky-400 flex-shrink-0"></i>
                    <span>{{ str_replace(['http://', 'https://'], '', url('/@' . $profile->clean_handle)) }}</span>
                </a>
            </div>

            <!-- Social / Professional Links -->
            @if(!empty($socialLinks) && count($socialLinks) > 0)
                <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center justify-center md:justify-start gap-2 pt-2">
                    @foreach($socialLinks as $soc)
                        <a href="{{ $soc->url }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl text-[11px] font-semibold text-zinc-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors print-badge">
                            <i data-lucide="external-link" class="w-3 h-3 text-sky-400 flex-shrink-0"></i>
                            <span class="truncate">{{ $soc->label ?: ucfirst($soc->platform) }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </header>

    <!-- Section 1: Professional Summary / Bio -->
    @if($profile->cv_summary || $profile->bio)
        <section class="py-5 sm:py-6 border-b border-white/10 print-border-b page-break-avoid">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 print-text-dark flex items-center gap-2 mb-3">
                <i data-lucide="user-check" class="w-4 h-4"></i>
                <span>Ringkasan Profesional</span>
            </h2>
            <p class="text-xs sm:text-sm leading-relaxed text-zinc-300 print-text-dark whitespace-pre-line">
                {{ $profile->cv_summary ?: $profile->bio }}
            </p>
        </section>
    @endif

    <!-- Section 2: Work Experience Timeline -->
    @if(!empty($experiences))
        <section class="py-5 sm:py-6 border-b border-white/10 print-border-b">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 print-text-dark flex items-center gap-2 mb-6">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
                <span>Pengalaman Kerja & Riwayat Karir</span>
            </h2>

            <div class="space-y-6">
                @foreach($experiences as $exp)
                    <div class="page-break-avoid relative pl-6 sm:pl-8 border-l-2 border-sky-500/30 print:border-l-slate-300">
                        <!-- Timeline Bullet Node -->
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-[#0b0f17] border-2 border-sky-400 print:bg-slate-700 print:border-slate-800"></div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                            <h3 class="text-sm sm:text-base font-bold text-white print-text-dark">
                                {{ $exp['role'] ?? 'Software Engineer' }}
                            </h3>
                            <span class="inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full bg-sky-500/10 text-sky-300 border border-sky-500/20 print-badge w-fit">
                                {{ $exp['period'] ?? '2022 - Sekarang' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2 text-xs font-medium text-zinc-400 print-text-muted mb-3">
                            <span class="font-bold text-zinc-300 print-text-dark">{{ $exp['company'] ?? 'Perusahaan' }}</span>
                            @if(!empty($exp['location']))
                                <span>&bull;</span>
                                <span class="inline-flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-zinc-500"></i>
                                    {{ $exp['location'] }}
                                </span>
                            @endif
                        </div>

                        @if(!empty($exp['description']))
                            <div class="text-xs sm:text-sm text-zinc-300 print-text-dark leading-relaxed whitespace-pre-line">
                                {{ $exp['description'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 3: Technical & Core Skills -->
    @if(!empty($skills))
        <section class="py-5 sm:py-6 border-b border-white/10 print-border-b page-break-avoid">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 print-text-dark flex items-center gap-2 mb-5">
                <i data-lucide="layers" class="w-4 h-4"></i>
                <span>Keahlian & Kompetensi Teknis</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($skills as $category => $skillList)
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-4 print-badge">
                        <h4 class="text-xs font-bold text-zinc-300 print-text-dark mb-2.5 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                            <span>{{ $category }}</span>
                        </h4>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach((array)$skillList as $skill)
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-white/10 text-zinc-200 border border-white/10 print:bg-white print:border-slate-300 print:text-black">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 4: Education & Training -->
    @if(!empty($educations))
        <section class="pt-5 sm:pt-6 page-break-avoid">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 print-text-dark flex items-center gap-2 mb-5">
                <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                <span>Pendidikan & Kualifikasi</span>
            </h2>

            <div class="space-y-4">
                @foreach($educations as $edu)
                    <div class="bg-white/5 border border-white/5 rounded-2xl p-4 sm:p-5 print-badge">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                            <h3 class="text-sm font-bold text-white print-text-dark">
                                {{ $edu['degree'] ?? 'Sarjana Komputer' }} &mdash; <span class="font-normal text-zinc-300 print-text-muted">{{ $edu['field_of_study'] ?? 'Teknik Informatika' }}</span>
                            </h3>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-white/10 text-zinc-300 border border-white/10 print-badge w-fit">
                                {{ $edu['period'] ?? '2018 - 2022' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-zinc-400 print-text-muted mb-2">
                            <span class="font-semibold text-zinc-300 print-text-dark">{{ $edu['school'] ?? 'Universitas' }}</span>
                            @if(!empty($edu['gpa']))
                                <span>&bull;</span>
                                <span class="text-emerald-400 font-semibold print-text-dark">IPK: {{ $edu['gpa'] }}</span>
                            @endif
                        </div>

                        @if(!empty($edu['description']))
                            <p class="text-xs text-zinc-300 print-text-dark leading-relaxed">
                                {{ $edu['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
