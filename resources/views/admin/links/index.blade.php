@extends('layouts.admin')

@section('title', 'Kelola Tautan Bio')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-white tracking-tight">Daftar Tautan & Konten</h2>
            <p class="text-xs text-zinc-400">Atur kartu tautan, pembatas kategori, dan video embed yang tampil di halaman profil Anda.</p>
        </div>
        <button onclick="openAddModal()" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold transition-all shadow-lg shadow-sky-500/20 inline-flex items-center gap-1.5">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Tautan Baru</span>
        </button>
    </div>

    <!-- Links List -->
    <div class="space-y-3" id="linksContainer">
        @forelse($links as $link)
            <div class="bg-zinc-900/70 border border-zinc-800 rounded-2xl p-4 flex items-center justify-between gap-4 transition-all hover:border-zinc-700" data-id="{{ $link->id }}">
                <div class="flex items-center gap-3.5 min-w-0">
                    <!-- Icon Indicator -->
                    <div class="w-10 h-10 rounded-xl bg-zinc-800 border border-zinc-700/80 flex items-center justify-center flex-shrink-0 text-zinc-300">
                        @if($link->type === 'header')
                            <i data-lucide="heading" class="w-5 h-5 text-purple-400"></i>
                        @elseif($link->type === 'embed_youtube')
                            <i data-lucide="youtube" class="w-5 h-5 text-red-400"></i>
                        @else
                            <i data-lucide="link" class="w-5 h-5 text-sky-400"></i>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sm text-white truncate">{{ $link->title }}</span>
                            @if($link->badge_text)
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-zinc-800 text-zinc-300 border border-zinc-700">
                                    {{ $link->badge_text }}
                                </span>
                            @endif
                            @if(!$link->is_active)
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-zinc-400 truncate mt-0.5 font-mono text-[11px]">
                            {{ $link->url ?: 'Pembatas Kategori (Header)' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-xs text-zinc-500 font-mono hidden sm:inline mr-2">
                        {{ $link->total_clicks }} klik
                    </span>

                    <!-- Active Toggle Button -->
                    <button onclick="toggleLinkActive({{ $link->id }}, this)" 
                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors {{ $link->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20' : 'bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700' }}">
                        {{ $link->is_active ? 'Aktif' : 'Mati' }}
                    </button>

                    <!-- Edit Button -->
                    <button type="button"
                            data-link="{{ json_encode($link) }}"
                            onclick="openEditModal(this)"
                            class="p-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white transition-colors" title="Edit Tautan">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>

                    <!-- Delete Form -->
                    <form action="{{ route('admin.links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Hapus tautan ini secara permanen?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 transition-colors" title="Hapus">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-zinc-900/40 border border-dashed border-zinc-800 rounded-2xl p-12 text-center text-zinc-500">
                <i data-lucide="link" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                <p class="text-sm">Belum ada tautan. Klik tombol di atas untuk menambahkan!</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Tautan -->
<div id="addModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Tambah Tautan / Konten Baru</h3>
            <button onclick="closeAddModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form action="{{ route('admin.links.store') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Tipe Konten</label>
                <select name="type" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="link">Tautan Standar (Web/Katalog/Kontak)</option>
                    <option value="header">Pembatas / Judul Kategori (Header)</option>
                    <option value="embed_youtube">Embed Video YouTube</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Tautan *</label>
                <input type="text" name="title" required placeholder="Contoh: GitHub windri-dev" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Subjudul / Deskripsi Singkat</label>
                <input type="text" name="subtitle" placeholder="Contoh: Kumpulan repositori open-source" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Tujuan</label>
                <input type="url" name="url" placeholder="https://..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Badge (Opsional)</label>
                    <input type="text" name="badge_text" placeholder="NEW, HOT, STAGING..." class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Warna Badge</label>
                    <select name="badge_color" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="emerald">Emerald (Hijau)</option>
                        <option value="sky">Sky (Biru)</option>
                        <option value="amber">Amber (Kuning/Emas)</option>
                        <option value="purple">Purple (Ungu)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="is_highlighted" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Animasi Sorotan (Glow/Pulse)</span>
                </label>
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" name="open_in_new_tab" value="1" checked class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Buka di Tab Baru</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Simpan Tautan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Tautan -->
<div id="editModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-white">Edit Tautan</h3>
            <button onclick="closeEditModal()" class="text-zinc-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>

        <form id="editForm" method="POST" class="space-y-3.5 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Tipe Konten</label>
                <select id="editType" name="type" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                    <option value="link">Tautan Standar</option>
                    <option value="header">Pembatas / Judul Kategori (Header)</option>
                    <option value="embed_youtube">Embed Video YouTube</option>
                </select>
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Judul Tautan *</label>
                <input type="text" id="editTitle" name="title" required class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">Subjudul / Deskripsi Singkat</label>
                <input type="text" id="editSubtitle" name="subtitle" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div>
                <label class="block text-zinc-300 font-semibold mb-1">URL Tujuan</label>
                <input type="url" id="editUrl" name="url" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Teks Badge</label>
                    <input type="text" id="editBadgeText" name="badge_text" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                </div>
                <div>
                    <label class="block text-zinc-300 font-semibold mb-1">Warna Badge</label>
                    <select id="editBadgeColor" name="badge_color" class="w-full bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-white focus:outline-none focus:border-sky-400">
                        <option value="emerald">Emerald (Hijau)</option>
                        <option value="sky">Sky (Biru)</option>
                        <option value="amber">Amber (Kuning/Emas)</option>
                        <option value="purple">Purple (Ungu)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="editHighlighted" name="is_highlighted" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Animasi Sorotan (Glow/Pulse)</span>
                </label>
                <label class="flex items-center gap-2 text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="editOpenInNewTab" name="open_in_new_tab" value="1" class="rounded bg-zinc-800 border-zinc-700 text-sky-500">
                    <span>Buka di Tab Baru</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-zinc-800">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-bold">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(btn) {
        try {
            const link = JSON.parse(btn.getAttribute('data-link'));
            const form = document.getElementById('editForm');
            form.action = `/admin/links/${link.id}`;

            document.getElementById('editType').value = link.type || 'link';
            document.getElementById('editTitle').value = link.title || '';
            document.getElementById('editSubtitle').value = link.subtitle || '';
            document.getElementById('editUrl').value = link.url || '';
            document.getElementById('editBadgeText').value = link.badge_text || '';
            document.getElementById('editBadgeColor').value = link.badge_color || 'emerald';
            document.getElementById('editHighlighted').checked = !!link.is_highlighted;
            document.getElementById('editOpenInNewTab').checked = !!link.open_in_new_tab;

            document.getElementById('editModal').classList.remove('hidden');
        } catch (e) {
            console.error('Failed to parse link data:', e);
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    async function toggleLinkActive(id, btn) {
        try {
            const res = await fetch(`/admin/links/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();
            if (data.success) {
                if (data.is_active) {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors bg-emerald-500/10 text-emerald-400 border-emerald-500/30 hover:bg-emerald-500/20';
                    btn.innerText = 'Aktif';
                } else {
                    btn.className = 'px-2.5 py-1.5 rounded-lg text-xs font-semibold border transition-colors bg-zinc-800 text-zinc-400 border-zinc-700 hover:bg-zinc-700';
                    btn.innerText = 'Mati';
                }
            }
        } catch (err) {
            alert('Gagal mengubah status tautan');
        }
    }
</script>
@endsection
