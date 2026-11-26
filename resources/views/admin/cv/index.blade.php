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
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                <i data-lucide="file-badge" class="w-6 h-6 text-sky-400"></i>
                <span>Curriculum Vitae (CV) Builder</span>
            </h1>
            <p class="text-xs text-zinc-400 mt-1">
                Susun riwayat karir, keahlian, dan portofolio profesional Anda. Siap cetak ke PDF atau bagikan langsung kepada recruiter.
            </p>
        </div>

        <div class="flex items-center flex-wrap gap-2.5">
            <!-- 1-Click Load Preset Template -->
            <form action="{{ route('admin.cv.template') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memuat templet standar profesional? Data CV saat ini akan diperbarui dengan data templet siap pakai.');">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 transition-all flex items-center gap-1.5 shadow-sm">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-400"></i>
                    <span>✨ Muat Templet Siap Pakai</span>
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

    <form action="{{ route('admin.cv.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Card 1: Pengaturan Visibilitas & Dokumen Asli -->
        <div class="bg-zinc-900/60 border border-zinc-800 rounded-3xl p-6 space-y-5">
            <h2 class="text-sm font-bold text-white flex items-center gap-2">
                <i data-lucide="settings" class="w-4 h-4 text-sky-400"></i>
                <span>Status & Dokumen CV</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Toggle Aktifkan CV -->
                <div class="flex items-start justify-between p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80">
                    <div>
                        <label for="enable_cv" class="text-xs font-bold text-white cursor-pointer">Aktifkan Halaman CV Publik</label>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Tampilkan tombol "Lihat CV" di BioLink dan buka URL /@ {{ $profile->clean_handle }}/cv.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input type="checkbox" name="enable_cv" id="enable_cv" value="1" class="sr-only peer" {{ old('enable_cv', $profile->enable_cv) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-zinc-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                    </label>
                </div>

                <!-- Template Layout -->
                <div class="p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80">
                    <label for="cv_template" class="block text-xs font-bold text-white mb-1.5">Gaya Desain Template CV</label>
                    <select name="cv_template" id="cv_template" class="w-full bg-zinc-900 border border-zinc-700/80 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                        <option value="modern" {{ old('cv_template', $profile->cv_template) === 'modern' ? 'selected' : '' }}>Modern Clean (Glassmorphism + Dark Mode)</option>
                        <option value="minimal" {{ old('cv_template', $profile->cv_template) === 'minimal' ? 'selected' : '' }}>Tech Minimalist (Fokus Konten & Typography)</option>
                        <option value="executive" {{ old('cv_template', $profile->cv_template) === 'executive' ? 'selected' : '' }}>Corporate Executive (Standar Korporat)</option>
                    </select>
                </div>
            </div>

            <!-- Upload Custom File CV (PDF/Doc) -->
            <div class="p-4 rounded-2xl bg-zinc-950/60 border border-zinc-800/80 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <label class="text-xs font-bold text-white flex items-center gap-1.5">
                            <i data-lucide="file-up" class="w-3.5 h-3.5 text-emerald-400"></i>
                            <span>Upload Berkas CV Custom (Opsional - PDF/DOCX)</span>
                        </label>
                        <p class="text-[11px] text-zinc-400 mt-0.5">Jika Anda sudah memiliki berkas PDF CV resmi, unggah di sini agar pengunjung dapat langsung mengunduhnya.</p>
                    </div>

                    @if($profile->cv_file_url)
                        <div class="flex items-center gap-2">
                            <a href="{{ $profile->cv_file_url }}" target="_blank" download class="px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 text-xs font-semibold flex items-center gap-1.5">
                                <i data-lucide="file-check" class="w-3.5 h-3.5"></i>
                                <span>Lihat Berkas Aktif</span>
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
                    <span>Keahlian & Kompetensi Teknis (Skills)</span>
                </h2>
                <span class="text-[11px] text-zinc-400 font-mono">Format: Kategori: Item 1, Item 2</span>
            </div>

            <p class="text-[11px] text-zinc-400">
                Tulis satu kategori per baris. Contoh:<br>
                <code class="text-sky-300 font-mono">Backend: PHP (Laravel), Python (FastAPI), Node.js, Redis</code><br>
                <code class="text-sky-300 font-mono">Frontend: Tailwind CSS, React, Vue.js, Alpine.js</code>
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
                        <span>Pengalaman Kerja & Riwayat Karir</span>
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
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nama Perusahaan / Organisasi</label>
                                <input type="text" name="experiences[{{ $index }}][company]" value="{{ $exp['company'] ?? '' }}" placeholder="Contoh: Tech Studio" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode / Waktu</label>
                                <input type="text" name="experiences[{{ $index }}][period]" value="{{ $exp['period'] ?? '' }}" placeholder="Contoh: 2022 - Sekarang" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Lokasi (Kota, Negara)</label>
                                <input type="text" name="experiences[{{ $index }}][location]" value="{{ $exp['location'] ?? '' }}" placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi Tugas & Pencapaian Utama</label>
                            <textarea name="experiences[{{ $index }}][description]" rows="3" placeholder="Gunakan tanda peluru (•) untuk membedakan tiap pencapaian..." class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500 leading-relaxed">{{ $exp['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-zinc-500 text-xs">
                        Belum ada riwayat pengalaman kerja. Klik "Tambah Posisi" atau gunakan "Muat Templet Siap Pakai".
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
                    <p class="text-[11px] text-zinc-400 mt-0.5">Institusi formal, universitas, atau program sertifikasi.</p>
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

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Gelar / Tingkat</label>
                                <input type="text" name="educations[{{ $index }}][degree]" value="{{ $edu['degree'] ?? '' }}" placeholder="Contoh: Sarjana Komputer (S.Kom)" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Jurusan / Bidang Studi</label>
                                <input type="text" name="educations[{{ $index }}][field_of_study]" value="{{ $edu['field_of_study'] ?? '' }}" placeholder="Contoh: Teknik Informatika" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Institusi / Universitas</label>
                                <input type="text" name="educations[{{ $index }}][school]" value="{{ $edu['school'] ?? '' }}" placeholder="Contoh: Universitas Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Tahun / Periode</label>
                                <input type="text" name="educations[{{ $index }}][period]" value="{{ $edu['period'] ?? '' }}" placeholder="Contoh: 2018 - 2022" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">IPK / Nilai Kelulusan</label>
                                <input type="text" name="educations[{{ $index }}][gpa]" value="{{ $edu['gpa'] ?? '' }}" placeholder="Contoh: 3.85 / 4.00" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Catatan / Penghargaan</label>
                                <input type="text" name="educations[{{ $index }}][description]" value="{{ $edu['description'] ?? '' }}" placeholder="Contoh: Cum Laude" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-zinc-500 text-xs">
                        Belum ada riwayat pendidikan. Klik "Tambah Pendidikan" atau gunakan "Muat Templet Siap Pakai".
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex items-center justify-between p-4 bg-zinc-900/90 border border-zinc-800 rounded-2xl sticky bottom-4 backdrop-blur-md shadow-2xl z-20">
            <p class="text-xs text-zinc-400">
                Perubahan akan langsung diperbarui di halaman CV Anda: 
                <a href="{{ route('public.cv', $profile->clean_handle) }}" target="_blank" class="text-sky-400 hover:underline">/@ {{ $profile->clean_handle }}/cv</a>
            </p>

            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-sky-500 hover:bg-sky-400 text-white transition-all hover:scale-[1.02] shadow-lg shadow-sky-500/20 flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Simpan Perubahan CV</span>
            </button>
        </div>

    </form>

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
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Nama Perusahaan</label>
                        <input type="text" name="experiences[${expIndex}][company]" placeholder="Contoh: Tech Global Ltd" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Periode / Waktu</label>
                        <input type="text" name="experiences[${expIndex}][period]" placeholder="Contoh: 2021 - 2023" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Lokasi</label>
                        <input type="text" name="experiences[${expIndex}][location]" placeholder="Contoh: Jakarta, Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Deskripsi & Tanggung Jawab</label>
                    <textarea name="experiences[${expIndex}][description]" rows="3" placeholder="Gunakan tanda peluru (•) untuk membedakan tiap pencapaian..." class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500 leading-relaxed"></textarea>
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

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Gelar / Tingkat</label>
                        <input type="text" name="educations[${eduIndex}][degree]" placeholder="Contoh: Sarjana Komputer" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Jurusan</label>
                        <input type="text" name="educations[${eduIndex}][field_of_study]" placeholder="Contoh: Sistem Informasi" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Institusi / Universitas</label>
                        <input type="text" name="educations[${eduIndex}][school]" placeholder="Contoh: Universitas Indonesia" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Tahun / Periode</label>
                        <input type="text" name="educations[${eduIndex}][period]" placeholder="Contoh: 2017 - 2021" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">IPK / Nilai</label>
                        <input type="text" name="educations[${eduIndex}][gpa]" placeholder="Contoh: 3.80" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-zinc-400 mb-1">Catatan</label>
                        <input type="text" name="educations[${eduIndex}][description]" placeholder="Contoh: Cum Laude" class="w-full bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-sky-500">
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        lucide.createIcons();
    }
</script>
@endsection
