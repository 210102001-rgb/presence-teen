{{-- Mobile Bottom Navigation Bar --}}
@php
    $role = Auth::check() ? Auth::user()->role : null;
@endphp

<nav class="fixed bottom-0 left-0 right-0 bg-surface z-40 lg:hidden shadow-lg rounded-t-xl"
     style="padding-bottom: max(12px, env(safe-area-inset-bottom));">
    <div class="flex items-center justify-around h-16 px-4">
        @if($role === 'siswa')
            <a href="{{ route('dashboard') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-opacity active:scale-90 duration-100
                      {{ request()->routeIs('dashboard*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('dashboard*') ? 'filled-icon' : '' }}">home</span>
                <span class="text-[10px] font-medium">Home</span>
                @if(request()->routeIs('dashboard*'))
                    <span class="w-1 h-1 bg-primary rounded-full"></span>
                @endif
            </a>

            <a href="{{ route('presensi.riwayat') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-opacity active:scale-90 duration-100
                      {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'filled-icon' : '' }}">history</span>
                <span class="text-[10px] font-medium">History</span>
                @if(request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail'))
                    <span class="w-1 h-1 bg-primary rounded-full"></span>
                @endif
            </a>

            <a href="{{ route('materi.index') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-opacity active:scale-90 duration-100
                      {{ request()->routeIs('materi.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('materi.*') ? 'filled-icon' : '' }}">auto_stories</span>
                <span class="text-[10px] font-medium">Learning</span>
                @if(request()->routeIs('materi.*'))
                    <span class="w-1 h-1 bg-primary rounded-full"></span>
                @endif
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-opacity active:scale-90 duration-100
                      {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('profile.*') ? 'filled-icon' : '' }}">person</span>
                <span class="text-[10px] font-medium">Profile</span>
                @if(request()->routeIs('profile.*'))
                    <span class="w-1 h-1 bg-primary rounded-full"></span>
                @endif
            </a>
        @elseif($role === 'guru')
            <a href="{{ route('dashboard') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('dashboard*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('dashboard*') ? 'filled-icon' : '' }}">dashboard</span>
                <span class="text-[10px] font-medium">Dashboard</span>
            </a>

            <a href="{{ route('presensi.guru') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('presensi.guru*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.guru*') ? 'filled-icon' : '' }}">qr_code_2</span>
                <span class="text-[10px] font-medium">Presensi</span>
            </a>

            <a href="{{ route('aktivitas.index') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('aktivitas.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('aktivitas.*') ? 'filled-icon' : '' }}">timer</span>
                <span class="text-[10px] font-medium">Aktivitas</span>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('profile.*') ? 'filled-icon' : '' }}">person</span>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('dashboard*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('dashboard*') ? 'filled-icon' : '' }}">dashboard</span>
                <span class="text-[10px] font-medium">Dashboard</span>
            </a>

            <a href="{{ route('presensi.riwayat') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'filled-icon' : '' }}">history</span>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>

            <a href="{{ route('aktivitas.index') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('aktivitas.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('aktivitas.*') ? 'filled-icon' : '' }}">timer</span>
                <span class="text-[10px] font-medium">Aktivitas</span>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-secondary' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('profile.*') ? 'filled-icon' : '' }}">person</span>
                <span class="text-[10px] font-medium">Profil</span>
            </a>
        @endif
    </div>
</nav>

{{-- Spacer so content doesn't hide behind bottom nav --}}
<div class="h-20 lg:hidden"></div>
