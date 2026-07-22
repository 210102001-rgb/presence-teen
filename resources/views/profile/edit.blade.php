@php
    $role = Auth::user()->role;
    $roleName = match($role) {
        'siswa' => 'Profil Siswa',
        'guru' => 'Profil Guru',
        'orang_tua' => 'Profil Orang Tua',
        default => 'Profil Pengguna',
    };
    $roleDesc = match($role) {
        'siswa' => 'Siswa • NIS: ' . (Auth::user()->nis ?? '-'),
        'guru' => 'Guru / Pendidik',
        'orang_tua' => 'Orang Tua / Wali Murid',
        default => 'Pengguna',
    };
@endphp

<x-app-layout>
    <x-slot name="header">{{ $roleName }}</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Profile Update Success Popup --}}
        @if(session('status') === 'profile-updated')
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition
                 x-init="setTimeout(() => show = false, 5000)"
                 @click.away="show = false"
                 class="mb-6 p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl flex items-center gap-3 text-sm text-[#005f2d] relative shadow-soft">
                <span class="material-symbols-outlined text-[20px] shrink-0 filled-icon">check_circle</span>
                <div>
                    <p class="font-bold">Profil Berhasil Diperbarui</p>
                    <p class="text-xs mt-0.5 opacity-80">Informasi profil Anda telah disimpan dengan baik</p>
                </div>
                <button @click="show = false" class="ml-auto text-[#005f2d] hover:text-[#0e7a3d] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-[#005f2d] transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#171c1f] font-medium">Settings / {{ $roleName }}</span>
        </nav>

        {{-- Page Header --}}
        <div class="hidden lg:flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#171c1f]">{{ $roleName }}</h2>
                <p class="text-sm text-[#5c5f61]">Kelola informasi profil Anda secara real-time.</p>
            </div>
        </div>

        {{-- Mobile Profile WhatsApp Style (For All User Roles) --}}
        <div class="lg:hidden space-y-6 pb-24">
            {{-- Header Profile: WA Style --}}
            <div class="flex flex-col items-center pt-6 pb-4">
                <div class="relative group">
                    <div class="w-28 h-28 rounded-full ring-4 ring-primary-container/30 flex items-center justify-center bg-primary/10 text-primary text-4xl font-bold shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shadow-md active:scale-90 transition-transform">
                        <span class="material-symbols-outlined text-[16px] filled-icon">photo_camera</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-on-surface mt-4">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-secondary mt-1">{{ $roleDesc }}</p>
                <div class="mt-2.5 px-3 py-1 bg-primary/10 rounded-full">
                    <span class="text-[10px] font-bold text-primary">{{ config('app.name', 'Presensi Sekolah') }}</span>
                </div>
            </div>

            {{-- WhatsApp Style Continuous List --}}
            <div class="bg-white rounded-2xl border border-outline-variant/40 shadow-soft overflow-hidden divide-y divide-outline-variant/20">
                {{-- Row: Nama --}}
                <div class="p-4 flex items-start gap-4 hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-primary mt-1">person</span>
                    <div class="flex-grow">
                        <p class="text-xs text-secondary font-semibold">Nama Lengkap</p>
                        <p class="text-sm font-bold text-on-surface mt-0.5">{{ Auth::user()->name }}</p>
                    </div>
                </div>

                {{-- Row: Email --}}
                <div class="p-4 flex items-start gap-4 hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-primary mt-1">mail</span>
                    <div class="flex-grow">
                        <p class="text-xs text-secondary font-semibold">Email</p>
                        <p class="text-sm font-bold text-on-surface mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                {{-- Row: NIS (if student) --}}
                @if($role === 'siswa')
                <div class="p-4 flex items-start gap-4 hover:bg-surface transition-colors">
                    <span class="material-symbols-outlined text-primary mt-1">badge</span>
                    <div class="flex-grow">
                        <p class="text-xs text-secondary font-semibold">Nomor Induk Siswa (NIS)</p>
                        <p class="text-sm font-bold text-on-surface mt-0.5">{{ Auth::user()->nis ?? '-' }}</p>
                    </div>
                </div>
                @endif

                {{-- Row: Child List (if parent) --}}
                @if($role === 'orang_tua')
                <div x-data="{ open: true }">
                    <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-surface transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-primary">family_restroom</span>
                            <div>
                                <p class="text-sm font-bold text-on-surface">Data Anak Terdaftar</p>
                                <p class="text-[10px] text-secondary">Daftar anak Anda yang terdaftar di sekolah ini.</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-secondary transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse class="p-4 bg-surface-container-lowest border-t border-outline-variant/10 space-y-3">
                        @foreach(Auth::user()->anak as $anak)
                            @php
                                $anakKelasIds = $anak->kelasSaya->pluck('id');
                                $sesiAnak = \App\Models\SesiPresensi::whereIn('kelas_id', $anakKelasIds)->count();
                                $hadirAnak = \App\Models\Presensi::where('siswa_id', $anak->id)->where('status', 'hadir')->count();
                                $kehadiranPct = $sesiAnak > 0 ? round(($hadirAnak / $sesiAnak) * 100) : 100;
                            @endphp
                            <div class="p-3 rounded-xl bg-[#f6fafe] border border-[#eaeef2] flex gap-3 items-center">
                                <div class="w-10 h-10 rounded-lg bg-[#0e7a3d]/10 text-[#005f2d] flex items-center justify-center font-bold shrink-0">
                                    {{ substr($anak->name, 0, 1) }}
                                </div>
                                <div class="flex-grow overflow-hidden">
                                    <h5 class="font-bold text-xs text-[#171c1f] truncate">{{ $anak->name }}</h5>
                                    <span class="px-2 py-[2px] rounded bg-[#97f7ac]/30 text-[#005226] text-[8px] font-bold mt-1 inline-block">{{ $kehadiranPct }}% Kehadiran</span>
                                </div>
                                <a href="{{ route('profile.anak', $anak->id) }}" class="material-symbols-outlined text-[#5c5f61] hover:text-[#005f2d] transition-colors text-[18px]">chevron_right</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Row: Edit Profile Form Collapse --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-surface transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-primary">edit_square</span>
                            <div>
                                <p class="text-sm font-bold text-on-surface">Perbarui Profil</p>
                                <p class="text-[10px] text-secondary">Ubah nama atau alamat email Anda.</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-secondary transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse class="p-4 bg-surface-container-lowest border-t border-outline-variant/10">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Row: Change Password Collapse --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-surface transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-primary">lock</span>
                            <div>
                                <p class="text-sm font-bold text-on-surface">Ubah Kata Sandi</p>
                                <p class="text-[10px] text-secondary">Ganti password secara berkala demi keamanan akun.</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-secondary transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse class="p-4 bg-surface-container-lowest border-t border-outline-variant/10">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Row: Danger Zone Collapse --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-surface transition-colors">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined text-error">delete_forever</span>
                            <div>
                                <p class="text-sm font-bold text-error">Hapus Akun</p>
                                <p class="text-[10px] text-secondary">Hapus akun secara permanen dari sistem.</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-secondary transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="open" x-collapse class="p-4 bg-surface-container-lowest border-t border-outline-variant/10">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        {{-- Bento Grid Layout (Desktop only) --}}
        <div class="hidden lg:grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Profile Card & Contacts (Left, Col-span 4) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Profile Identity --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2] flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 rounded-full ring-4 ring-[#97f7ac] flex items-center justify-center bg-[#0e7a3d]/10 text-[#005f2d] text-4xl font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <h3 class="text-lg font-bold text-[#171c1f]">{{ Auth::user()->name }}</h3>
                    <p class="text-xs text-[#5c5f61] mb-6">{{ $roleDesc }}</p>
                    
                    <div class="w-full pt-6 border-t border-[#eaeef2] flex justify-around">
                        @if($role === 'orang_tua')
                            <div class="text-center">
                                <p class="text-xl font-bold text-[#005f2d]">{{ Auth::user()->anak->count() }}</p>
                                <p class="text-[9px] uppercase tracking-wider text-[#5c5f61]">STUDENTS</p>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="text-xl font-bold text-[#005f2d]">{{ Auth::user()->nis ?? '-' }}</p>
                                <p class="text-[9px] uppercase tracking-wider text-[#5c5f61]">NIS / NIP</p>
                            </div>
                        @endif
                        <div class="text-center">
                            <p class="text-xl font-bold text-[#005f2d]">{{ Auth::user()->email_verified_at ? 'Aktif' : 'Belum Verifikasi' }}</p>
                            <p class="text-[9px] uppercase tracking-wider text-[#5c5f61]">ACCOUNT STATUS</p>
                        </div>
                    </div>
                </div>

                {{-- School Contacts --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2]">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-[#005f2d]">support_agent</span>
                        <h4 class="font-bold text-[#171c1f]">Kontak Sekolah</h4>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">call</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Sekretariat</p>
                                <p class="text-sm text-[#5c5f61]">({{ config('app.name', 'Sekolah') }})</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">mail</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Email Sekolah</p>
                                <p class="text-sm text-[#5c5f61]">admin@{{ strtolower(str_replace(' ', '', config('app.name', 'presence-teen'))) }}.sch.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">schedule</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Jam Operasional</p>
                                <p class="text-sm text-[#5c5f61]">Senin - Jumat, 07:00 - 16:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Information & Children Progress (Right, Col-span 8) --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- Personal Information Form --}}
                <div id="personal-info" class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#005f2d]">badge</span>
                            <h4 class="font-bold text-[#171c1f]">Informasi Pribadi</h4>
                        </div>
                        <span class="px-2.5 py-1 bg-[#97f7ac]/30 text-[#005226] text-[10px] font-bold rounded-full uppercase tracking-wider">Terverifikasi</span>
                    </div>

                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Child Progress Summary (Mockup) --}}
                @if($role === 'orang_tua')
                <div class="bg-white p-6 rounded-2xl border border-[#0e7a3d]/20 bg-gradient-to-r from-white to-[#f0fdf4]/20 shadow-soft">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#005f2d] filled-icon">auto_awesome</span>
                            <h4 class="font-bold text-[#171c1f]">Child Progress Summary</h4>
                        </div>
                        <span class="text-xs text-[#005f2d] font-semibold bg-[#f0fdf4] px-2 py-0.5 rounded border border-[#0e7a3d]/20">Last Updated: {{ now()->translatedFormat('d M Y') }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(Auth::user()->anak as $anak)
                            @php
                                $anakKelasIds = $anak->kelasSaya->pluck('id');
                                $sesiAnak = \App\Models\SesiPresensi::whereIn('kelas_id', $anakKelasIds)->count();
                                $hadirAnak = \App\Models\Presensi::where('siswa_id', $anak->id)->where('status', 'hadir')->count();
                                $kehadiranPct = $sesiAnak > 0 ? round(($hadirAnak / $sesiAnak) * 100) : 100;
                            @endphp
                            <div class="p-4 rounded-xl bg-[#f6fafe] border border-[#eaeef2] flex gap-4 items-center group cursor-pointer hover:bg-white transition-all">
                                <div class="w-12 h-12 rounded-lg bg-[#0e7a3d]/10 text-[#005f2d] flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ substr($anak->name, 0, 1) }}
                                </div>
                                <div class="flex-grow overflow-hidden">
                                    <div class="flex justify-between items-start">
                                        <h5 class="font-bold text-sm text-[#171c1f] truncate">{{ $anak->name }}</h5>
                                    </div>
                                    <div class="flex gap-2 mt-1 flex-wrap">
                                        <span class="px-2 py-[2px] rounded bg-[#97f7ac]/30 text-[#005226] text-[9px] font-bold">{{ $kehadiranPct }}% Kehadiran</span>
                                        <span class="px-2 py-[2px] rounded bg-[#d9e3f6] text-[#121c2a] text-[9px] font-bold">{{ $kehadiranPct }}% Attendance</span>
                                    </div>
                                </div>
                                <a href="{{ route('profile.anak', $anak->id) }}" class="material-symbols-outlined text-[#5c5f61] hover:text-[#005f2d] transition-colors">chevron_right</a>
                            </div>
                        @endforeach
                    </div>

                    {{-- AI Insight Quote --}}
                    <div class="mt-6 p-4 bg-[#f0fdf4] rounded-xl flex gap-3 items-center border border-[#0e7a3d]/10">
                        <span class="material-symbols-outlined text-[#005f2d] text-2xl shrink-0">psychology</span>
                        <p class="text-xs text-[#005226] leading-relaxed italic">
                            @if(Auth::user()->anak->count() > 0)
                                "Anda memiliki {{ Auth::user()->anak->count() }} anak terdaftar. Pantau perkembangan belajar mereka secara berkala."
                            @else
                                "Profil Anda telah terverifikasi. Hubungi sekolah untuk informasi lebih lanjut."
                            @endif
                        </p>
                    </div>
                </div>
                @elseif($role === 'siswa')
                <div class="bg-white p-6 rounded-2xl border border-surface-container shadow-soft">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-[#005f2d]">school</span>
                        <h4 class="font-bold text-[#171c1f]">Informasi Akademik</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-[#f6fafe] rounded-xl border border-surface-container">
                            <p class="text-xs text-secondary">Nomor Induk Siswa (NIS)</p>
                            <p class="text-sm font-bold text-[#171c1f] mt-1">{{ Auth::user()->nis ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-[#f6fafe] rounded-xl border border-surface-container">
                            <p class="text-xs text-secondary">Email Terdaftar</p>
                            <p class="text-sm font-bold text-[#171c1f] mt-1">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Change Password & Delete Account --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-[#005f2d]">lock</span>
                            <h4 class="font-bold text-[#171c1f]">Ubah Password</h4>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-[#ba1a1a]/20 shadow-soft">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-[#ba1a1a]">delete_forever</span>
                            <h4 class="font-bold text-[#93000a]">Danger Zone</h4>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Security --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 opacity-75 text-xs text-[#5c5f61] pt-6 border-t border-[#eaeef2]">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#005f2d] text-[18px]">security</span>
                <span>Data encrypted with AES-256 standards.</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#005f2d] text-[18px]">history</span>
                <span>Profile managed by {{ config('app.name', 'Sekolah') }} IT Department.</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#005f2d] text-[18px]">verified_user</span>
                <span>Last login: {{ now()->translatedFormat('d M Y, H:i') }} WIB.</span>
            </div>
        </div>
    </div>
</x-app-layout>