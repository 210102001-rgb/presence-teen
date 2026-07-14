{{-- Mobile Bottom Navigation Bar --}}
@php
    $role = Auth::check() ? Auth::user()->role : null;
    $currentRoute = request()->route();
@endphp

<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-[#eaeef2] z-40 lg:hidden pb-safe"
     style="padding-bottom: max(12px, env(safe-area-inset-bottom));">
    <div class="flex items-center justify-around h-16">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                  {{ request()->routeIs('dashboard') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
            <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('dashboard') ? 'filled-icon' : '' }}">dashboard</span>
            <span class="text-[9px] font-semibold leading-tight">Dashboard</span>
        </a>

        {{-- Presensi --}}
        @if($role === 'siswa')
            <a href="{{ route('presensi.scan') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('presensi.scan') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.scan') ? 'filled-icon' : '' }}">qr_code_scanner</span>
                <span class="text-[9px] font-semibold leading-tight">Presensi</span>
            </a>
        @elseif($role === 'guru')
            <a href="{{ route('presensi.guru') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('presensi.guru*') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.guru*') ? 'filled-icon' : '' }}">qr_code_2</span>
                <span class="text-[9px] font-semibold leading-tight">Presensi</span>
            </a>
        @else
            <a href="{{ route('presensi.riwayat') }}"
               class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                      {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('presensi.riwayat') || request()->routeIs('presensi.detail') ? 'filled-icon' : '' }}">history</span>
                <span class="text-[9px] font-semibold leading-tight">Riwayat</span>
            </a>
        @endif

        {{-- Aktivitas --}}
        <a href="{{ route('aktivitas.index') }}"
           class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                  {{ request()->routeIs('aktivitas.*') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
            <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('aktivitas.*') ? 'filled-icon' : '' }}">timer</span>
            <span class="text-[9px] font-semibold leading-tight">Aktivitas</span>
        </a>

        {{-- AI Insight --}}
        <button wire:click="toggleChat"
                class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors text-[#5c5f61]">
            <span class="material-symbols-outlined text-[22px]">smart_toy</span>
            <span class="text-[9px] font-semibold leading-tight">AI Insight</span>
        </button>

        {{-- Profil --}}
        <a href="{{ route('profile.edit') }}"
           class="flex flex-col items-center justify-center gap-0.5 w-16 py-1 transition-colors
                  {{ request()->routeIs('profile.*') ? 'text-[#005f2d]' : 'text-[#5c5f61]' }}">
            <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('profile.*') ? 'filled-icon' : '' }}">person</span>
            <span class="text-[9px] font-semibold leading-tight">Profil</span>
        </a>
    </div>
</nav>

{{-- Spacer so content doesn't hide behind bottom nav --}}
<div class="h-16 lg:hidden"></div>
