@extends('layouts.admin')

@section('title', 'Master Kontrol Super Admin')

@section('content')
<div class="space-y-6">

    <!-- Header & Nav Submenu -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 uppercase">Super Admin Access</span>
                <span class="text-xs text-zinc-500 font-mono">• Kontrol Platform Penuh</span>
            </div>
            <h2 class="text-xl font-black text-white tracking-tight">Master Kontrol Pengguna & Audit Tautan</h2>
            <p class="text-xs text-zinc-400">Pantau seluruh pengguna yang mendaftar, telusuri tujuan tautan yang mereka buat, dan amankan platform dari penyalahgunaan.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.master.links') }}" class="px-3.5 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-semibold border border-zinc-700 transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="list-filter" class="w-4 h-4 text-sky-400"></i>
                <span>Audit Seluruh Tautan ({{ $totalLinks }})</span>
            </a>
        </div>
    </div>

    <!-- Global Platform Overview Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3.5">
        <div class="spotlight-card p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <span class="text-[11px] font-medium text-zinc-400 block mb-1">Total Pengguna</span>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-black text-white">{{ number_format($totalUsers) }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">Akun</span>
            </div>
        </div>

        <div class="spotlight-card p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <span class="text-[11px] font-medium text-zinc-400 block mb-1">Total Tautan Dibuat</span>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-black text-sky-400">{{ number_format($totalLinks) }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">Links</span>
            </div>
        </div>

        <div class="spotlight-card p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <span class="text-[11px] font-medium text-zinc-400 block mb-1">Total Tayangan Profil</span>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-black text-emerald-400">{{ number_format($totalViews) }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">Views</span>
            </div>
        </div>

        <div class="spotlight-card p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800">
            <span class="text-[11px] font-medium text-zinc-400 block mb-1">Total Klik Tautan</span>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-black text-indigo-400">{{ number_format($totalClicks) }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">Clicks</span>
            </div>
        </div>

        <div class="spotlight-card p-4 rounded-2xl bg-zinc-900/80 border border-zinc-800 col-span-2 sm:col-span-1">
            <span class="text-[11px] font-medium text-zinc-400 block mb-1">Ditangguhkan / Suspend</span>
            <div class="flex items-baseline gap-2">
                <span class="text-xl font-black {{ $suspendedUsersCount > 0 ? 'text-rose-400' : 'text-zinc-400' }}">{{ $suspendedUsersCount }}</span>
                <span class="text-[10px] text-zinc-500 font-mono">Akun</span>
            </div>
        </div>
    </div>

    <!-- Live Recent Links Creation Feed (What are users using BioLink for?) -->
    <div class="bg-zinc-900/70 border border-zinc-800 rounded-3xl p-5 space-y-3.5 shadow-xl">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></div>
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">Aktivitas Tautan Baru Terkini (Live Feed)</h3>
            </div>
            <span class="text-[11px] text-zinc-500 font-mono">Pantauan Real-Time</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            @forelse($recentLinks as $rl)
                <div class="p-3 rounded-2xl bg-zinc-950/70 border border-zinc-850 hover:border-zinc-700 transition-colors space-y-1.5">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('public.bio.at', $rl->profile->handle ?? 'unknown') }}" target="_blank" class="text-[11px] font-mono font-bold text-sky-400 hover:underline truncate max-w-[140px]">
                            {{ '@' . ($rl->profile->handle ?? 'unknown') }}
                        </a>
                        <span class="text-[9px] text-zinc-500 font-mono">{{ $rl->created_at?->diffForHumans() }}</span>
                    </div>

                    <h4 class="text-xs font-bold text-white truncate" title="{{ $rl->title }}">{{ $rl->title }}</h4>

                    <div class="flex items-center gap-1.5 text-[11px] text-zinc-400 font-mono truncate" title="{{ $rl->url }}">
                        <i data-lucide="external-link" class="w-3 h-3 text-zinc-500 flex-shrink-0"></i>
                        <span class="truncate">{{ $rl->url }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-4 text-center text-xs text-zinc-500">
                    Belum ada tautan yang dibuat.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-zinc-900/60 border border-zinc-800 rounded-2xl p-3">
        <form action="{{ route('admin.master.index') }}" method="GET" class="flex-grow w-full sm:w-auto flex items-center gap-2">
            <div class="relative flex-grow">
                <span class="absolute left-3 top-2.5 text-zinc-500">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari pengguna (nama, email, handle @username, isi bio)..." 
                       class="w-full bg-zinc-800/80 border border-zinc-700 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-zinc-500 focus:outline-none focus:border-sky-400">
            </div>

            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <button type="submit" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-xs font-bold text-white border border-zinc-700">
                Cari
            </button>
            @if($search || $status)
                <a href="{{ route('admin.master.index') }}" class="px-3 py-2 rounded-xl bg-zinc-800/50 hover:bg-zinc-800 text-xs text-zinc-400 hover:text-white" title="Reset Pencarian">
                    Reset
                </a>
            @endif
        </form>

        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1 text-xs self-stretch sm:self-auto justify-end">
            <a href="{{ route('admin.master.index', ['search' => $search]) }}" class="px-3 py-1.5 rounded-lg {{ !$status ? 'bg-sky-500/20 text-sky-300 font-bold border border-sky-500/30' : 'text-zinc-400 hover:bg-zinc-800' }}">Semua</a>
            <a href="{{ route('admin.master.index', ['status' => 'active', 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg {{ $status === 'active' ? 'bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30' : 'text-zinc-400 hover:bg-zinc-800' }}">Aktif</a>
            <a href="{{ route('admin.master.index', ['status' => 'suspended', 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg {{ $status === 'suspended' ? 'bg-rose-500/20 text-rose-300 font-bold border border-rose-500/30' : 'text-zinc-400 hover:bg-zinc-800' }}">Ditangguhkan</a>
        </div>
    </div>

    <!-- Users Master Audit Table -->
    <div class="bg-zinc-900/80 border border-zinc-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800 bg-zinc-950/60 text-zinc-400 font-semibold uppercase text-[10px] tracking-wider">
                        <th class="p-4 sm:p-5">Pengguna & Handle</th>
                        <th class="p-4 sm:p-5">Tujuan Penggunaan (Bio & Tautan)</th>
                        <th class="p-4 sm:p-5 text-center">Tautan</th>
                        <th class="p-4 sm:p-5 text-center">Tayangan</th>
                        <th class="p-4 sm:p-5 text-center">Status</th>
                        <th class="p-4 sm:p-5 text-right">Tindakan Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 text-zinc-300">
                    @forelse($users as $u)
                        @php
                            $p = $u->profile;
                            $userLinks = $p?->bioLinks ?? collect();
                        @endphp
                        <tr class="hover:bg-zinc-800/30 transition-colors {{ $u->isSuspended() ? 'bg-rose-950/10' : '' }}">
                            <!-- User Column -->
                            <td class="p-4 sm:p-5 align-top">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-zinc-800 border border-zinc-700 overflow-hidden flex-shrink-0 mt-0.5">
                                        <img src="{{ $p?->avatar_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80' }}" alt="Avatar" class="w-full h-full object-cover">
                                    </div>
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="font-bold text-white text-sm">{{ $u->name }}</span>
                                            @if($u->isSuperAdmin())
                                                <span class="text-[9px] font-mono px-1.5 py-0.2 bg-amber-500/20 text-amber-300 rounded font-bold border border-amber-500/30">MASTER</span>
                                            @endif
                                            @if($u->hasTwoFactorEnabled())
                                                <span class="text-[9px] font-mono px-1.5 py-0.2 bg-emerald-500/20 text-emerald-300 rounded font-bold border border-emerald-500/30 inline-flex items-center gap-1" title="2FA Authenticator Aktif">
                                                    <i data-lucide="shield-check" class="w-2.5 h-2.5"></i>
                                                    <span>2FA ON</span>
                                                </span>
                                            @else
                                                <span class="text-[9px] font-mono px-1.5 py-0.2 bg-zinc-800 text-zinc-400 rounded border border-zinc-700" title="2FA Belum Diaktifkan">2FA OFF</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-zinc-400">{{ $u->email }}</div>
                                        @if($p)
                                            <a href="{{ route('public.bio.at', $p->handle) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-mono text-sky-400 hover:underline">
                                                <span>{{ '@' . $p->handle }}</span>
                                                <i data-lucide="external-link" class="w-3 h-3"></i>
                                            </a>
                                        @else
                                            <span class="text-[10px] text-zinc-500 font-mono italic">Belum buat profil</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Usage Purpose Column (Bio & Top Destination Links) -->
                            <td class="p-4 sm:p-5 align-top max-w-sm">
                                <div class="space-y-2">
                                    @if($p?->bio)
                                        <p class="text-xs text-zinc-300/90 leading-relaxed line-clamp-2 italic bg-zinc-950/40 p-2 rounded-xl border border-zinc-850">
                                            "{{ $p->bio }}"
                                        </p>
                                    @else
                                        <span class="text-[11px] text-zinc-500 italic">Tidak ada bio terisi</span>
                                    @endif

                                    <!-- Sample Destination Links Preview -->
                                    @if($userLinks->isNotEmpty())
                                        <div class="space-y-1">
                                            <span class="text-[10px] font-mono text-zinc-500 block">Tautan dibuat:</span>
                                            @foreach($userLinks->take(2) as $ul)
                                                <div class="flex items-center gap-1.5 text-[11px] text-zinc-400 bg-zinc-900 px-2 py-1 rounded-lg border border-zinc-800">
                                                    <span class="font-bold text-white truncate max-w-[120px]">{{ $ul->title }}</span>
                                                    <span class="text-zinc-600">&rarr;</span>
                                                    <span class="truncate text-sky-400/80 font-mono flex-grow" title="{{ $ul->url }}">{{ parse_url($ul->url, PHP_URL_HOST) ?: $ul->url }}</span>
                                                </div>
                                            @endforeach
                                            @if($userLinks->count() > 2)
                                                <button type="button" onclick="inspectUserModal({{ $u->id }})" class="text-[10px] text-zinc-400 hover:text-white font-semibold">
                                                    + {{ $userLinks->count() - 2 }} tautan lainnya...
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] text-zinc-600 font-mono block">0 tautan aktif</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Link Count -->
                            <td class="p-4 sm:p-5 align-top text-center font-mono">
                                <span class="font-bold text-white">{{ $userLinks->count() }}</span>
                            </td>

                            <!-- Views Count -->
                            <td class="p-4 sm:p-5 align-top text-center font-mono">
                                <span class="font-bold text-emerald-400">{{ number_format($p?->total_views ?? 0) }}</span>
                            </td>

                            <!-- Status Badge -->
                            <td class="p-4 sm:p-5 align-top text-center">
                                @if($u->isSuspended())
                                    <span class="inline-flex items-center gap-1 text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 border border-rose-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        DITANGGUHKAN
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-mono font-bold px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        AKTIF
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 sm:p-5 align-top text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Detailed Audit Button -->
                                    <button type="button" 
                                            onclick="inspectUserModal({{ $u->id }})"
                                            class="px-2.5 py-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white text-xs font-semibold border border-zinc-700 transition-colors inline-flex items-center gap-1"
                                            title="Audit Detail Lengkap">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-sky-400"></i>
                                        <span>Audit</span>
                                    </button>

                                    @if(!$u->isSuperAdmin())
                                        <!-- Suspend / Activate Toggle -->
                                        <form action="{{ route('admin.master.user.toggle-status', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status pengguna ini?')">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-1.5 rounded-lg {{ $u->isSuspended() ? 'bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30' : 'bg-amber-500/20 text-amber-300 hover:bg-amber-500/30' }} transition-colors"
                                                    title="{{ $u->isSuspended() ? 'Aktifkan Kembali Akun' : 'Tangguhkan / Suspend Akun' }}">
                                                <i data-lucide="{{ $u->isSuspended() ? 'check-circle' : 'slash' }}" class="w-4 h-4"></i>
                                            </button>
                                        </form>

                                        <!-- Delete User -->
                                        <form action="{{ route('admin.master.user.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Hapus permanen pengguna ini beserta seluruh data profil, tautan, dan basis pengetahuan AI miliknya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-zinc-800 hover:bg-rose-500/20 text-zinc-400 hover:text-rose-400 transition-colors" title="Hapus Permanen">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-zinc-500">
                                <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                <p class="text-xs">Tidak ditemukan pengguna yang cocok dengan kriteria pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-zinc-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Detailed User Audit Modal -->
<div id="userAuditModal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl max-w-2xl w-full p-6 space-y-4 shadow-2xl max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3 flex-shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center">
                    <i data-lucide="shield-alert" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white" id="modalUserName">Audit Detail Pengguna</h3>
                    <p class="text-[11px] text-zinc-400 font-mono" id="modalUserHandle">@handle</p>
                </div>
            </div>
            <button onclick="closeAuditModal()" class="text-zinc-400 hover:text-white p-1">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div id="modalLoading" class="py-12 text-center text-xs text-zinc-400">
            <div class="w-6 h-6 border-2 border-sky-400 border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
            Memuat seluruh data tautan dan riwayat...
        </div>

        <div id="modalBody" class="space-y-4 overflow-y-auto pr-1 flex-grow hidden text-xs">
            <!-- Profile Info Box -->
            <div class="p-3.5 rounded-2xl bg-zinc-950/70 border border-zinc-800 space-y-2">
                <span class="text-[10px] font-mono uppercase text-zinc-500 font-bold block">Biografi & Deskripsi Profil</span>
                <p id="modalBioText" class="text-zinc-300 leading-relaxed italic"></p>
                <div class="flex items-center gap-4 text-[11px] text-zinc-400 font-mono pt-1">
                    <span>Engine AI: <strong class="text-sky-400" id="modalAiEngine">-</strong></span>
                    <span>Total Tayangan: <strong class="text-emerald-400" id="modalViews">-</strong></span>
                </div>
            </div>

            <!-- Links Inventory Section -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <h4 class="font-bold text-white uppercase text-[11px] tracking-wider">Daftar Tautan yang Dibuat Pengguna</h4>
                    <span id="modalLinksCount" class="text-[10px] font-mono bg-zinc-800 px-2 py-0.5 rounded text-zinc-300">0 Links</span>
                </div>

                <div id="modalLinksContainer" class="space-y-2">
                    <!-- Populated via JS -->
                </div>
            </div>
        </div>

        <div class="pt-3 border-t border-zinc-800 flex justify-end gap-2 flex-shrink-0">
            <button onclick="closeAuditModal()" class="px-4 py-2 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 text-xs font-semibold">Tutup</button>
        </div>
    </div>
</div>

<script>
    async function inspectUserModal(userId) {
        const modal = document.getElementById('userAuditModal');
        const loading = document.getElementById('modalLoading');
        const body = document.getElementById('modalBody');

        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        body.classList.add('hidden');

        try {
            const res = await fetch(`/admin/master-control/users/${userId}`);
            const data = await res.json();

            document.getElementById('modalUserName').innerText = data.user.name + ' (' + data.user.email + ')';
            document.getElementById('modalUserHandle').innerText = data.profile ? '@' + data.profile.handle : 'Tanpa Handle';
            document.getElementById('modalBioText').innerText = data.profile?.bio || '(Pengguna belum mengisi bio)';
            document.getElementById('modalAiEngine').innerText = (data.profile?.ai_provider || 'local').toUpperCase();
            document.getElementById('modalViews').innerText = data.profile?.total_views || '0';
            document.getElementById('modalLinksCount').innerText = data.links.length + ' Tautan';

            const container = document.getElementById('modalLinksContainer');
            container.innerHTML = '';

            if (data.links.length === 0) {
                container.innerHTML = '<p class="text-zinc-500 italic py-2">Pengguna ini belum membuat tautan sama sekali.</p>';
            } else {
                data.links.forEach(l => {
                    const item = document.createElement('div');
                    item.className = 'p-3 rounded-xl bg-zinc-950/80 border border-zinc-800 flex items-center justify-between gap-3';
                    item.innerHTML = `
                        <div class="min-w-0 space-y-0.5 flex-grow">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-white text-xs">${l.title}</span>
                                <span class="text-[9px] font-mono px-1.5 py-0.2 rounded ${l.is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-zinc-800 text-zinc-500'}">${l.is_active ? 'AKTIF' : 'NONAKTIF'}</span>
                            </div>
                            <a href="${l.url}" target="_blank" class="text-[11px] font-mono text-sky-400 hover:underline truncate block max-w-md">
                                ${l.url}
                            </a>
                        </div>
                        <div class="flex items-center gap-3 text-right flex-shrink-0">
                            <span class="text-[11px] font-mono text-zinc-400 font-bold">${l.click_count} Klik</span>
                            <form action="/admin/master-control/links/${l.id}/toggle" method="POST" class="inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="p-1 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-300 text-[10px]" title="Toggle Aktif/Nonaktif">
                                    ${l.is_active ? 'Nonaktifkan' : 'Aktifkan'}
                                </button>
                            </form>
                        </div>
                    `;
                    container.appendChild(item);
                });
            }

            loading.classList.add('hidden');
            body.classList.remove('hidden');
        } catch (err) {
            alert('Gagal memuat data pengguna: ' + err.message);
            closeAuditModal();
        }
    }

    function closeAuditModal() {
        document.getElementById('userAuditModal').classList.add('hidden');
    }
</script>
@endsection
