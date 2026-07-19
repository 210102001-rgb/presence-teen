<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>

    <div class="p-4 md:p-8 space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold text-on-surface">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-secondary mt-1">Kelola sistem Presence Teen dari dashboard ini</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Users --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-secondary uppercase tracking-wider font-semibold">Total Pengguna</p>
                        <p class="text-3xl font-bold text-on-surface mt-2">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[24px]">people</span>
                    </div>
                </div>
                <div class="mt-4 text-xs space-y-1">
                    <p class="flex justify-between"><span class="text-secondary">Guru:</span> <span class="font-semibold text-on-surface">{{ $totalGuru }}</span></p>
                    <p class="flex justify-between"><span class="text-secondary">Siswa:</span> <span class="font-semibold text-on-surface">{{ $totalSiswa }}</span></p>
                    <p class="flex justify-between"><span class="text-secondary">Orang Tua:</span> <span class="font-semibold text-on-surface">{{ $totalOrangTua }}</span></p>
                </div>
            </div>

            {{-- Total Kelas --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-secondary uppercase tracking-wider font-semibold">Total Kelas</p>
                        <p class="text-3xl font-bold text-on-surface mt-2">{{ $totalKelas }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-secondary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary text-[24px]">class</span>
                    </div>
                </div>
                <p class="mt-4 text-xs text-secondary">Semua kelas di sistem</p>
            </div>

            {{-- Total Materi --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-secondary uppercase tracking-wider font-semibold">Total Materi</p>
                        <p class="text-3xl font-bold text-on-surface mt-2">{{ $totalMateri }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-tertiary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary text-[24px]">menu_book</span>
                    </div>
                </div>
                <p class="mt-4 text-xs text-secondary">Materi pembelajaran</p>
            </div>

            {{-- Total Presensi --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs text-secondary uppercase tracking-wider font-semibold">Total Presensi</p>
                        <p class="text-3xl font-bold text-on-surface mt-2">{{ $totalPresensi }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-error/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-error text-[24px]">check_circle</span>
                    </div>
                </div>
                <p class="mt-4 text-xs text-secondary">Catatan kehadiran</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Users --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-on-surface">Pengguna Terbaru</h2>
                    <a href="{{ route('account.index') }}" class="text-sm text-primary hover:text-primary-container font-semibold">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between py-3 border-b border-surface-container last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/15 flex items-center justify-center text-primary text-sm font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-on-surface">{{ $user->name }}</p>
                                    <p class="text-xs text-secondary">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full
                                @if($user->role === 'guru') bg-secondary/15 text-secondary
                                @elseif($user->role === 'siswa') bg-tertiary/15 text-tertiary
                                @elseif($user->role === 'orang_tua') bg-error/15 text-error
                                @elseif($user->role === 'super_admin') bg-primary/15 text-primary
                                @endif">
                                @if($user->role === 'guru') Guru
                                @elseif($user->role === 'siswa') Siswa
                                @elseif($user->role === 'orang_tua') Orang Tua
                                @elseif($user->role === 'super_admin') Admin
                                @endif
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-secondary text-center py-6">Belum ada pengguna</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Classes --}}
            <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-on-surface">Kelas Terbaru</h2>
                    <a href="{{ route('guru.kelas') }}" class="text-sm text-primary hover:text-primary-container font-semibold">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentKelas as $kelas)
                        <div class="py-3 border-b border-surface-container last:border-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-medium text-on-surface">{{ $kelas->nama_kelas }}</p>
                                <span class="text-xs font-semibold text-secondary">{{ $kelas->siswa()->count() }} siswa</span>
                            </div>
                            <p class="text-xs text-secondary">
                                <span class="font-semibold">{{ $kelas->mata_pelajaran }}</span> • 
                                <span>Guru: {{ $kelas->waliKelas->name ?? '-' }}</span>
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-secondary text-center py-6">Belum ada kelas</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-primary-container rounded-2xl shadow-soft border border-primary/20 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('account.create') }}" class="flex items-center gap-3 p-4 rounded-xl bg-white hover:bg-surface-container transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">person_add</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-on-surface">Tambah Pengguna</p>
                        <p class="text-xs text-secondary">Buat akun baru</p>
                    </div>
                </a>

                <a href="{{ route('account.index') }}" class="flex items-center gap-3 p-4 rounded-xl bg-white hover:bg-surface-container transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-secondary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary text-[20px]">manage_accounts</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-on-surface">Kelola Akun</p>
                        <p class="text-xs text-secondary">Edit atau hapus akun</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.guru') }}" class="flex items-center gap-3 p-4 rounded-xl bg-white hover:bg-surface-container transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-tertiary/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">preview</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-on-surface">Lihat Portal Guru</p>
                        <p class="text-xs text-secondary">Akses fitur guru</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-primary/10 border border-primary/20 rounded-2xl p-6">
            <div class="flex gap-4">
                <span class="material-symbols-outlined text-primary text-[24px] shrink-0">security</span>
                <div>
                    <h3 class="font-semibold text-on-surface mb-1">Akses Super Admin</h3>
                    <p class="text-sm text-secondary">Anda adalah satu-satunya super admin di sistem. Gunakan privilege ini dengan bijak untuk mengelola semua akun pengguna dan pengaturan sistem.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
