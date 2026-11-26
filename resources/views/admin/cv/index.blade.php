@extends('layouts.admin')

@section('title', 'Curriculum Vitae (CV) Builder')

@section('content')
<div class="space-y-6">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-800">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-sky-400 bg-sky-500/10 px-2.5 py-0.5 rounded-full border border-sky-500/20">
                    Fitur Karir Profesional
                </span>
                @if($profile->enable_cv)
                    <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Aktif (Publik)</span>
                    </span>
                @else
                    <span class="text-[11px] font-mono font-bold px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-400 border border-zinc-700">
                        Nonaktif (Tersembunyi)
                    </span>
                @endif
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                <i data-lucide="file-badge" class="w-6 h-6 text-sky-400"></i>
                <span>Curriculum Vitae (CV) Builder</span>
            </h1>
            <p class="text-xs text-zinc-400 mt-1">
                Susun riwayat karir, keahlian, dan portofolio profesional Anda. Pratinjau langsung hasilnya di sebelah kanan.
            </p>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <!-- 1-Click Fast Toggle Active/Inactive -->
            <form action="{{ route('admin.cv.toggle') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm {{ $profile->enable_cv ? 'bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white border border-zinc-700' : 'bg-emerald-500 hover:bg-emerald-400 text-white shadow-emerald-500/20' }}"
                        title="{{ $profile->enable_cv ? 'Klik untuk menyembunyikan CV dari publik' : 'Klik untuk mengaktifkan CV agar dapat diakses publik' }}">
                    <i data-lucide="{{ $profile->enable_cv ? 'eye-off' : 'eye' }}" class="w-3.5 h-3.5"></i>
                    <span>{{ $profile->enable_cv ? 'Nonaktifkan CV' : 'Aktifkan CV' }}</span>
                </button>
            </form>

            <!-- 1-Click Load Preset Template -->
            <form action="{{ route('admin.cv.template') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memuat templet standar profesional? Data CV saat ini akan diperbarui dengan data templet siap pakai.');">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 transition-all flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>✨ Muat Templet</span>
                </button>
            </form>

            <!-- Preview Public CV -->
            <a href="{{ route('public.cv', $profile->clean_handle) }}" 
               target="_blank" 
               class="px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-all flex items-center gap-1.5 shadow-sm">
                <i data-lucide="external-link" class="w-3.5 h-3.5 text-sky-400"></i>
                <span>Lihat CV Publik</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs space-y-1">
            <p class="font-bold flex items-center gap-2"><i data-lucide="alert-triangle" class="w-4 h-4"></i> Terjadi kesalahan validasi:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 2-Column Responsive Layout: Left Editor Form + Right Live Result Showcase -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- ================================================================= -->
        <!-- LEFT COLUMN: CV FORM BUILDER (lg:col-span-7)                      -->
        <!-- ================================================================= -->
        <div class="lg:col-span-7 space-y-6">
            <form action="{{ route('admin.cv.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Card 1: Pengaturan Visibilitas & Dokumen Asli -->
                <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-5">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i data-lucide="settings" class="w-4 h-4 text-sky-400"></i>
                        <span>Status & Dokumen CV</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Toggle Aktifkan CV (with hidden fallback to ensure 0 when unchecked) -->
                        <div class="flex items-start justify-between p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80">
                            <div>
                                <label for="enable_cv" class="text-xs font-bold text-white cursor-pointer block">Status CV Publik</label>
                                <p class="text-[11px] text-zinc-400 mt-0.5">Aktifkan untuk memunculkan tombol CV di Bio.</p>
                            </div>
                            <input type="hidden" name="enable_cv" value="0">
                            <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                                <input type="checkbox" name="enable_cv" id="enable_cv" value="1" class="sr-only peer" {{ old('enable_cv', $profile->enable_cv) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                            </label>
                        </div>

                        <!-- Template Layout -->
                        <div class="p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80">
                            <label for="cv_template" class="block text-xs font-bold text-white mb-1.5">Gaya Desain Template</label>
                            <select name="cv_template" id="cv_template" class="w-full bg-zinc-900 border border-zinc-700/80 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                <option value="modern" {{ old('cv_template', $profile->cv_template) === 'modern' ? 'selected' : '' }}>Modern Clean (Glassmorphism)</option>
                                <option value="minimal" {{ old('cv_template', $profile->cv_template) === 'minimal' ? 'selected' : '' }}>Tech Minimalist (Simple)</option>
                                <option value="executive" {{ old('cv_template', $profile->cv_template) === 'executive' ? 'selected' : '' }}>Corporate Executive (Korporat)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload Custom File CV (PDF/Doc) -->
                    <div class="p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <label class="text-xs font-bold text-white flex items-center gap-1.5">
                                    <i data-lucide="file-up" class="w-3.5 h-3.5 text-emerald-400"></i>
                                    <span>Upload Berkas CV Resmi (Opsional - PDF/DOCX)</span>
                                </label>
                                <p class="text-[11px] text-zinc-400 mt-0.5">Pengunjung akan dapat langsung mengunduh berkas PDF asli Anda.</p>
                            </div>

                            @if($profile->cv_file_url)
                                <div class="flex items-center gap-2">
                                    <a href="{{ $profile->cv_file_url }}" target="_blank" download class="px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs font-semibold flex items-center gap-1.5">
                                        <i data-lucide="file-check" class="w-3.5 h-3.5"></i>
                                        <span>Lihat PDF Aktif</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="file" name="cv_file" accept=".pdf,.doc,.docx" class="text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700">
                        </div>
                    </div>
                </div>

                <!-- Card 2: Headline & Ringkasan Profesional -->
                <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-4">
                    <h2 class="text-sm font-bold text-white flex items-center gap-2">
                        <i data-lucide="user-check" class="w-4 h-4 text-sky-400"></i>
                        <span>Headline & Ringkasan Profesional</span>
                    </h2>

                    <div>
                        <label for="cv_headline" class="block text-xs font-bold text-zinc-300 mb-1">Judul Posisi / Profesional Headline</label>
                        <input type="text" name="cv_headline" id="cv_headline" 
                               value="{{ old('cv_headline', $profile->cv_headline ?: $profile->tagline) }}" 
                               placeholder="Contoh: Senior Full-Stack Software Engineer & System Architect"
                               class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-500">
                    </div>

                    <div>
                        <label for="cv_summary" class="block text-xs font-bold text-zinc-300 mb-1">Ringkasan Karir / Career Summary</label>
                        <textarea name="cv_summary" id="cv_summary" rows="4" 
                                  placeholder="Jelaskan ringkasan pengalaman karir, keunggulan teknis, dan pencapaian Anda..."
                                  class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-500 leading-relaxed">{{ old('cv_summary', $profile->cv_summary ?: $profile->bio) }}</textarea>
                    </div>
                </div>

                <!-- Card 3: Keahlian & Keterampilan (Skills) -->
                <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-white flex items-center gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-sky-400"></i>
                            <span>Keahlian Teknis (Skills)</span>
                        </h2>
                        <span class="text-[11px] text-zinc-400 font-mono">Format: Kategori: Item 1, Item 2</span>
                    </div>

                    <p class="text-[11px] text-zinc-400">
                        Tulis satu kategori per baris. Contoh:<br>
                        <code class="text-sky-300 font-mono">Backend: PHP (Laravel), Python (FastAPI), Redis</code><br>
                        <code class="text-sky-300 font-mono">Frontend: Tailwind CSS, Vue.js, React</code>
                    </p>

                    @php
                        $skillsRawText = '';
                        if (!empty($skills) && is_array($skills)) {
                            foreach ($skills as $cat => $items) {
                                $skillsRawText .= $cat . ': ' . implode(', ', (array)$items) . "\n";
                            }
                        }
                    @endphp

                    <textarea name="skills_raw" id="skills_raw" rows="5" 
                              class="w-full bg-zinc-950 border border-zinc-800 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-500 font-mono leading-relaxed">{{ old('skills_raw', trim($skillsRawText)) }}</textarea>
                </div>

                <!-- Card 4: Riwayat Pengalaman Kerja (Experiences) -->
                <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                                <i data-lucide="briefcase" class="w-4 h-4 text-sky-400"></i>
                                <span>Pengalaman Kerja</span>
                            </h2>
                            <p class="text-[11px] text-zinc-400 mt-0.5">Urutkan dari posisi terbaru/saat ini.</p>
                        </div>

                        <button type="button" onclick="addExperienceRow()" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-sky-500/10 hover:bg-sky-500/20 text-sky-300 border border-sky-500/30 transition-all flex items-center gap-1.5">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Posisi</span>
                        </button>
                    </div>

                    <div id="experiences-container" class="space-y-4">
                        @php $expList = old('experiences', $experiences ?? []); @endphp
                        @forelse($expList as $index => $exp)
                            <div class="experience-item bg-zinc-950/80 border border-zinc-800 rounded-2xl p-4 space-y-3 relative group">
                                <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                                    <span class="text-xs font-mono font-bold text-sky-400 flex items-center gap-1.5">
                                        <i data-lucide="building" class="w-3.5 h-3.5"></i>
                                        <span>Posisi #{{ $loop->iteration }}</span>
                                    </span>
                                    <button type="button" onclick="this.closest('.experience-item').remove()" class="text-zinc-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Posisi / Jabatan</label>
                                        <input type="text" name="experiences[{{ $index }}][role]" value="{{ $exp['role'] ?? '' }}" placeholder="Contoh: Lead Full-Stack Engineer" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Perusahaan / Organisasi</label>
                                        <input type="text" name="experiences[{{ $index }}][company]" value="{{ $exp['company'] ?? '' }}" placeholder="Contoh: Tech Studio" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode / Waktu</label>
                                        <input type="text" name="experiences[{{ $index }}][period]" value="{{ $exp['period'] ?? '' }}" placeholder="Contoh: 2022 - Sekarang" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Lokasi</label>
                                        <input type="text" name="experiences[{{ $index }}][location]" value="{{ $exp['location'] ?? '' }}" placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi Tugas & Pencapaian</label>
                                    <textarea name="experiences[{{ $index }}][description]" rows="3" placeholder="Gunakan tanda peluru (•) untuk tiap pencapaian..." class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500 leading-relaxed">{{ $exp['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-zinc-500 text-xs">
                                Belum ada riwayat pengalaman kerja. Klik "Tambah Posisi" atau gunakan "Muat Templet".
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Card 5: Riwayat Pendidikan (Educations) -->
                <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                                <i data-lucide="graduation-cap" class="w-4 h-4 text-sky-400"></i>
                                <span>Pendidikan & Kualifikasi</span>
                            </h2>
                            <p class="text-[11px] text-zinc-400 mt-0.5">Institusi formal, universitas, atau sertifikasi.</p>
                        </div>

                        <button type="button" onclick="addEducationRow()" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-sky-500/10 hover:bg-sky-500/20 text-sky-300 border border-sky-500/30 transition-all flex items-center gap-1.5">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah Pendidikan</span>
                        </button>
                    </div>

                    <div id="educations-container" class="space-y-4">
                        @php $eduList = old('educations', $educations ?? []); @endphp
                        @forelse($eduList as $index => $edu)
                            <div class="education-item bg-zinc-950/80 border border-zinc-800 rounded-2xl p-4 space-y-3 relative group">
                                <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                                    <span class="text-xs font-mono font-bold text-sky-400 flex items-center gap-1.5">
                                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                                        <span>Pendidikan #{{ $loop->iteration }}</span>
                                    </span>
                                    <button type="button" onclick="this.closest('.education-item').remove()" class="text-zinc-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Gelar / Tingkat</label>
                                        <input type="text" name="educations[{{ $index }}][degree]" value="{{ $edu['degree'] ?? '' }}" placeholder="Contoh: Sarjana Komputer (S.Kom)" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Jurusan / Bidang</label>
                                        <input type="text" name="educations[{{ $index }}][field_of_study]" value="{{ $edu['field_of_study'] ?? '' }}" placeholder="Contoh: Teknik Informatika" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Institusi / Universitas</label>
                                        <input type="text" name="educations[{{ $index }}][school]" value="{{ $edu['school'] ?? '' }}" placeholder="Contoh: Universitas Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode</label>
                                        <input type="text" name="educations[{{ $index }}][period]" value="{{ $edu['period'] ?? '' }}" placeholder="Contoh: 2018 - 2022" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-zinc-500 text-xs">
                                Belum ada riwayat pendidikan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Submit Bar -->
                <div class="flex items-center justify-between p-4 bg-zinc-900/90 border border-zinc-800 rounded-2xl sticky bottom-4 backdrop-blur-md shadow-2xl z-20">
                    <p class="text-xs text-zinc-400">
                        Perubahan akan langsung disimpan ke profil Anda.
                    </p>

                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-sky-500 hover:bg-sky-400 text-white transition-all hover:scale-[1.02] shadow-lg shadow-sky-500/20 flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Simpan Perubahan CV</span>
                    </button>
                </div>

            </form>
        </div>

        <!-- ================================================================= -->
        <!-- RIGHT COLUMN: LIVE RESULT DISPLAY "DI SEBELAH" (lg:col-span-5)    -->
        <!-- ================================================================= -->
        <div class="lg:col-span-5 sticky top-20 space-y-4">
            
            <div class="bg-zinc-900/90 border border-zinc-800 rounded-3xl p-5 shadow-2xl space-y-4">
                
                <!-- Status & Action Header -->
                <div class="flex items-center justify-between pb-3 border-b border-zinc-800">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full {{ $profile->enable_cv ? 'bg-emerald-400 animate-pulse' : 'bg-zinc-600' }}"></div>
                        <span class="text-xs font-bold text-white">Hasil Pratinjau CV</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.cv.toggle') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="text-[11px] font-bold px-2.5 py-1 rounded-lg transition-colors border {{ $profile->enable_cv ? 'bg-emerald-500/10 text-emerald-300 border-emerald-500/30 hover:bg-red-500/10 hover:text-red-300 hover:border-red-500/30' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-emerald-500/15 hover:text-emerald-300' }}"
                                    title="Klik untuk langsung ubah status aktif/nonaktif">
                                {{ $profile->enable_cv ? '● Publik (Klik Nonaktif)' : '○ Nonaktif (Klik Aktif)' }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Live Mini Resume Render -->
                <div class="bg-zinc-950 rounded-2xl border border-zinc-800/90 p-4 space-y-4 max-h-[calc(100vh-220px)] overflow-y-auto">
                    
                    <!-- Identity Header -->
                    <div class="flex items-start gap-3">
                        <img src="{{ $profile->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }}" 
                             alt="{{ $profile->display_name }}" 
                             class="w-12 h-12 rounded-xl object-cover border border-white/10 flex-shrink-0">
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-white flex items-center gap-1.5 truncate">
                                <span>{{ $profile->display_name }}</span>
                                @if($profile->is_verified)
                                    <svg class="w-3.5 h-3.5 text-sky-400 fill-current inline flex-shrink-0" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                @endif
                            </h3>
                            <p class="text-xs font-semibold text-sky-400 truncate">
                                {{ $profile->cv_headline ?: $profile->tagline ?: 'Professional Engineer' }}
                            </p>
                            @if($profile->location)
                                <p class="text-[11px] text-zinc-400 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3 text-rose-400"></i>
                                    <span>{{ $profile->location }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Summary Preview -->
                    @if($profile->cv_summary || $profile->bio)
                        <div class="text-[11px] text-zinc-300 leading-relaxed bg-white/5 p-3 rounded-xl border border-white/5">
                            <span class="text-[10px] font-mono font-bold uppercase text-sky-400 block mb-1">Ringkasan:</span>
                            <p class="line-clamp-3">{{ $profile->cv_summary ?: $profile->bio }}</p>
                        </div>
                    @endif

                    <!-- Experiences Preview -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[11px] font-mono font-bold text-zinc-400">
                            <span>PENGALAMAN KERJA ({{ count($profile->cv_experiences ?? []) }})</span>
                        </div>

                        <div class="space-y-2">
                            @forelse(array_slice($profile->cv_experiences ?? [], 0, 3) as $exp)
                                <div class="p-2.5 rounded-xl bg-zinc-900 border border-zinc-800 text-xs space-y-1">
                                    <div class="flex items-center justify-between gap-1">
                                        <strong class="text-white truncate">{{ $exp['role'] ?? 'Role' }}</strong>
                                        <span class="text-[10px] font-mono px-1.5 py-0.2 rounded bg-sky-500/10 text-sky-300 border border-sky-500/20 whitespace-nowrap">
                                            {{ $exp['period'] ?? '' }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-zinc-400 truncate">{{ $exp['company'] ?? 'Perusahaan' }}</p>
                                </div>
                            @empty
                                <p class="text-[11px] text-zinc-500 italic">Belum ada pengalaman terdaftar.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Skills Badges Preview -->
                    @if(!empty($profile->cv_skills))
                        <div class="space-y-1.5">
                            <span class="text-[10px] font-mono font-bold uppercase text-zinc-400 block">KEAHLIAN UTAMA:</span>
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $allSkills = [];
                                    foreach ($profile->cv_skills as $c => $sList) {
                                        $allSkills = array_merge($allSkills, (array)$sList);
                                    }
                                    $previewSkills = array_slice($allSkills, 0, 6);
                                @endphp
                                @foreach($previewSkills as $sk)
                                    <span class="text-[10px] px-2 py-0.5 rounded-md bg-white/5 text-zinc-300 border border-white/10 font-mono">
                                        {{ $sk }}
                                    </span>
                                @endforeach
                                @if(count($allSkills) > 6)
                                    <span class="text-[10px] px-1.5 py-0.5 text-zinc-500 font-mono">+{{ count($allSkills) - 6 }} lainnya</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Educations Preview -->
                    @if(!empty($profile->cv_educations))
                        <div class="space-y-1.5 pt-1">
                            <span class="text-[10px] font-mono font-bold uppercase text-zinc-400 block">PENDIDIKAN:</span>
                            @foreach(array_slice($profile->cv_educations, 0, 2) as $edu)
                                <div class="text-[11px] p-2 rounded-lg bg-zinc-900/60 border border-zinc-800 text-zinc-300">
                                    <span class="font-bold text-white">{{ $edu['degree'] ?? '' }}</span>
                                    <span class="text-zinc-400">&bull; {{ $edu['school'] ?? '' }} ({{ $edu['period'] ?? '' }})</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>

                <!-- Footer Quick Links -->
                <div class="pt-2 flex items-center gap-2">
                    <a href="{{ route('public.cv', $profile->clean_handle) }}" 
                       target="_blank" 
                       class="flex-1 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-white text-xs font-bold transition-all border border-zinc-700 flex items-center justify-center gap-1.5 shadow-sm">
                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-sky-400"></i>
                        <span>Buka Halaman Lengkap</span>
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
    let expIndex = {{ count($expList ?? []) + 100 }};
    let eduIndex = {{ count($eduList ?? []) + 100 }};

    function addExperienceRow() {
        expIndex++;
        const container = document.getElementById('experiences-container');
        const count = container.querySelectorAll('.experience-item').length + 1;

        const html = `
            <div class="experience-item bg-zinc-950/80 border border-zinc-800 rounded-2xl p-4 space-y-3 relative group">
                <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                    <span class="text-xs font-mono font-bold text-sky-400 flex items-center gap-1.5">
                        <i data-lucide="building" class="w-3.5 h-3.5"></i>
                        <span>Posisi Baru (#${count})</span>
                    </span>
                    <button type="button" onclick="this.closest('.experience-item').remove()" class="text-zinc-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Posisi / Jabatan</label>
                        <input type="text" name="experiences[${expIndex}][role]" placeholder="Contoh: Senior Software Engineer" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Perusahaan</label>
                        <input type="text" name="experiences[${expIndex}][company]" placeholder="Contoh: Tech Studio" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode</label>
                        <input type="text" name="experiences[${expIndex}][period]" placeholder="Contoh: 2021 - 2023" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Lokasi</label>
                        <input type="text" name="experiences[${expIndex}][location]" placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi Tugas</label>
                    <textarea name="experiences[${expIndex}][description]" rows="3" placeholder="Gunakan tanda peluru (•) untuk tiap pencapaian..." class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500 leading-relaxed"></textarea>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        lucide.createIcons();
    }

    function addEducationRow() {
        eduIndex++;
        const container = document.getElementById('educations-container');
        const count = container.querySelectorAll('.education-item').length + 1;

        const html = `
            <div class="education-item bg-zinc-950/80 border border-zinc-800 rounded-2xl p-4 space-y-3 relative group">
                <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                    <span class="text-xs font-mono font-bold text-sky-400 flex items-center gap-1.5">
                        <i data-lucide="award" class="w-3.5 h-3.5"></i>
                        <span>Pendidikan Baru (#${count})</span>
                    </span>
                    <button type="button" onclick="this.closest('.education-item').remove()" class="text-zinc-500 hover:text-red-400 transition-colors text-xs flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        <span>Hapus</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Gelar / Tingkat</label>
                        <input type="text" name="educations[${eduIndex}][degree]" placeholder="Contoh: Sarjana Komputer" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Jurusan</label>
                        <input type="text" name="educations[${eduIndex}][field_of_study]" placeholder="Contoh: Teknik Informatika" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Institusi / Universitas</label>
                        <input type="text" name="educations[${eduIndex}][school]" placeholder="Contoh: Universitas Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode</label>
                        <input type="text" name="educations[${eduIndex}][period]" placeholder="Contoh: 2018 - 2022" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        lucide.createIcons();
    }
</script>
@endsection
