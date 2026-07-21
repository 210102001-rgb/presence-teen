@php
    $role = Auth::check() ? Auth::user()->role : null;
@endphp

<aside class="-translate-x-full lg:translate-x-0 bg-primary-container text-on-primary-container h-screen w-64 fixed left-0 top-0 shadow-md flex flex-col py-6 px-4 z-50 overflow-y-auto transform transition-transform duration-300 ease-in-out"
       :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    {{-- Brand --}}
    <div class="flex items-center gap-3 mb-8 px-2">
        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shrink-0 overflow-hidden">
            <img src="{{ asset('smansa.png') }}" class="w-full h-full object-contain" alt="Smansa Logo">
        </div>
        <div>
            <h1 class="text-base font-bold text-white leading-none">Presence-Teen</h1>
            <p class="text-[10px] text-white/60 uppercase tracking-widest mt-0.5">
                @if($role === 'guru') Portal Guru
                @elseif($role === 'siswa') Portal Siswa
                @elseif($role === 'orang_tua') Portal Orang Tua
                @elseif($role === 'super_admin') Portal Admin
                @else Academic Portal
                @endif
            </p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                  {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*')
                     ? 'bg-white/15 text-white font-semibold'
                     : 'text-white/75 hover:text-white hover:bg-white/10' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*') ? 'filled-icon' : '' }}">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>

        @if($role === 'super_admin')
            <a href="{{ route('account.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('account.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('account.*') ? 'filled-icon' : '' }}">manage_accounts</span>
                <span class="text-sm">Kelola Akun</span>
            </a>
            <a href="{{ route('presensi.guru') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.guru*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.guru*') ? 'filled-icon' : '' }}">qr_code_2</span>
                <span class="text-sm">QR Presensi</span>
            </a>
            <a href="{{ route('presensi.manual') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.manual*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.manual*') ? 'filled-icon' : '' }}">edit_calendar</span>
                <span class="text-sm">Input Manual</span>
            </a>
            <a href="{{ route('guru.jadwal') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.jadwal*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.jadwal*') ? 'filled-icon' : '' }}">calendar_today</span>
                <span class="text-sm">Jadwal Mengajar</span>
            </a>
            <a href="{{ route('guru.kelas') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.kelas') || request()->routeIs('guru.kelas.store') || request()->routeIs('guru.kelas.update') || request()->routeIs('guru.kelas.destroy')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.kelas') || request()->routeIs('guru.kelas.store') || request()->routeIs('guru.kelas.update') || request()->routeIs('guru.kelas.destroy') ? 'filled-icon' : '' }}">class</span>
                <span class="text-sm">Kelas</span>
            </a>
            <a href="{{ route('guru.kelas_siswa') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.kelas_siswa*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.kelas_siswa*') ? 'filled-icon' : '' }}">groups</span>
                <span class="text-sm">Siswa</span>
            </a>
            <a href="{{ route('materi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('materi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('materi.*') ? 'filled-icon' : '' }}">menu_book</span>
                <span class="text-sm">Materi</span>
            </a>
            <a href="{{ route('tugas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('tugas.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('tugas.*') ? 'filled-icon' : '' }}">assignment</span>
                <span class="text-sm">Kelola Tugas</span>
            </a>
            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('laporan.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('laporan.*') ? 'filled-icon' : '' }}">monitoring</span>
                <span class="text-sm">Laporan Siswa</span>
            </a>
            <a href="{{ route('pengumuman.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('pengumuman.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('pengumuman.*') ? 'filled-icon' : '' }}">campaign</span>
                <span class="text-sm">Pengumuman</span>
            </a>

        @elseif($role === 'siswa')
            <a href="{{ route('presensi.scan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.scan')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.scan') ? 'filled-icon' : '' }}">qr_code_scanner</span>
                <span class="text-sm">Scan Presensi</span>
            </a>
            <a href="{{ route('presensi.riwayat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.riwayat') ? 'filled-icon' : '' }}">history</span>
                <span class="text-sm">Riwayat Presensi</span>
            </a>
            <a href="{{ route('tugas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('tugas.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('tugas.*') ? 'filled-icon' : '' }}">assignment</span>
                <span class="text-sm">Tugas</span>
            </a>
            <a href="{{ route('materi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('materi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('materi.*') ? 'filled-icon' : '' }}">menu_book</span>
                <span class="text-sm">Materi</span>
            </a>
            <a href="{{ route('aktivitas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('aktivitas.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('aktivitas.*') ? 'filled-icon' : '' }}">timer</span>
                <span class="text-sm">Aktivitas Belajar</span>
            </a>
            <a href="{{ route('motivasi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('motivasi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('motivasi.*') ? 'filled-icon' : '' }}">auto_awesome</span>
                <span class="text-sm">AI Analisis</span>
            </a>
            <a href="{{ route('pengumuman.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('pengumuman.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('pengumuman.*') ? 'filled-icon' : '' }}">campaign</span>
                <span class="text-sm">Pengumuman</span>
            </a>

        @elseif($role === 'guru')
            <a href="{{ route('presensi.guru') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.guru*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.guru*') ? 'filled-icon' : '' }}">qr_code_2</span>
                <span class="text-sm">QR Presensi</span>
            </a>
            <a href="{{ route('presensi.manual') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.manual*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.manual*') ? 'filled-icon' : '' }}">edit_calendar</span>
                <span class="text-sm">Input Manual</span>
            </a>
            <a href="{{ route('guru.jadwal') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.jadwal*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.jadwal*') ? 'filled-icon' : '' }}">calendar_today</span>
                <span class="text-sm">Jadwal Mengajar</span>
            </a>
            <a href="{{ route('guru.kelas') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.kelas') || request()->routeIs('guru.kelas.store') || request()->routeIs('guru.kelas.update') || request()->routeIs('guru.kelas.destroy')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.kelas') || request()->routeIs('guru.kelas.store') || request()->routeIs('guru.kelas.update') || request()->routeIs('guru.kelas.destroy') ? 'filled-icon' : '' }}">class</span>
                <span class="text-sm">Kelas</span>
            </a>
            <a href="{{ route('guru.kelas_siswa') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('guru.kelas_siswa*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('guru.kelas_siswa*') ? 'filled-icon' : '' }}">groups</span>
                <span class="text-sm">Siswa</span>
            </a>
            <a href="{{ route('materi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('materi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('materi.*') ? 'filled-icon' : '' }}">menu_book</span>
                <span class="text-sm">Materi</span>
            </a>
            <a href="{{ route('tugas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('tugas.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('tugas.*') ? 'filled-icon' : '' }}">assignment</span>
                <span class="text-sm">Kelola Tugas</span>
            </a>
            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('laporan.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('laporan.*') ? 'filled-icon' : '' }}">monitoring</span>
                <span class="text-sm">Laporan Siswa</span>
            </a>
            <a href="{{ route('pengumuman.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('pengumuman.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('pengumuman.*') ? 'filled-icon' : '' }}">campaign</span>
                <span class="text-sm">Pengumuman</span>
            </a>

        @elseif($role === 'orang_tua')
            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('laporan.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('laporan.*') ? 'filled-icon' : '' }}">monitoring</span>
                <span class="text-sm">Laporan Anak</span>
            </a>
            <a href="{{ route('presensi.riwayat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('presensi.riwayat') ? 'filled-icon' : '' }}">history</span>
                <span class="text-sm">Riwayat Presensi</span>
            </a>
            <a href="{{ route('aktivitas.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('aktivitas.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('aktivitas.*') ? 'filled-icon' : '' }}">timer</span>
                <span class="text-sm">Aktivitas Anak</span>
            </a>
            <a href="{{ route('motivasi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('motivasi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('motivasi.*') ? 'filled-icon' : '' }}">auto_awesome</span>
                <span class="text-sm">AI Analisis Anak</span>
            </a>
            <a href="{{ route('prediksi.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('prediksi.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('prediksi.*') ? 'filled-icon' : '' }}">stacked_line_chart</span>
                <span class="text-sm">Prediksi Absensi</span>
            </a>
            <a href="{{ route('pengumuman.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150 active:scale-95
                      {{ request()->routeIs('pengumuman.*')
                         ? 'bg-white/15 text-white font-semibold'
                         : 'text-white/75 hover:text-white hover:bg-white/10' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('pengumuman.*') ? 'filled-icon' : '' }}">campaign</span>
                <span class="text-sm">Pengumuman</span>
            </a>
        @endif
    </nav>

    {{-- Bottom: Profile & Logout --}}
    <div class="pt-4 border-t border-white/15 mt-4">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-150
                  {{ request()->routeIs('profile.*')
                     ? 'bg-white/15 text-white font-semibold'
                     : 'text-white/75 hover:text-white hover:bg-white/10' }}">
            <span class="material-symbols-outlined">manage_accounts</span>
            <span class="text-sm">Profil</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-white/75 hover:text-white hover:bg-white/10 transition-all duration-150 active:scale-95">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm">Keluar</span>
            </button>
        </form>

        {{-- User Info --}}
        <div class="mt-3 flex items-center gap-3 px-2 py-3 bg-white/10 rounded-xl">
            <div class="w-9 h-9 rounded-full bg-primary-fixed flex items-center justify-center text-primary text-sm font-bold shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-white/50 truncate capitalize">{{ Auth::user()->role ?? 'User' }}</p>
            </div>
        </div>
    </div>
</aside>
