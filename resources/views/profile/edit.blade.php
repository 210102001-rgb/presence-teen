<x-app-layout>
    <x-slot name="header">Parent Profile</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-1.5 text-xs text-[#5c5f61] mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-[#005f2d] transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#171c1f] font-medium">Settings / Parent Profile</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-[#171c1f]">Parent Profile</h2>
                <p class="text-sm text-[#5c5f61]">Manage your personal information and student associations.</p>
            </div>
            <a href="#personal-info" class="bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#0e7a3d] transition-all flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">edit</span> Edit Profile
            </a>
        </div>

        {{-- Bento Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
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
                    <p class="text-xs text-[#5c5f61] mb-6">Orang Tua / Wali Murid</p>
                    
                    <div class="w-full pt-6 border-t border-[#eaeef2] flex justify-around">
                        <div class="text-center">
                            <p class="text-xl font-bold text-[#005f2d]">{{ Auth::user()->anak->count() }}</p>
                            <p class="text-[9px] uppercase tracking-wider text-[#5c5f61]">STUDENTS</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-[#005f2d]">A+</p>
                            <p class="text-[9px] uppercase tracking-wider text-[#5c5f61]">ACCOUNT STATUS</p>
                        </div>
                    </div>
                </div>

                {{-- School Contacts --}}
                <div class="bg-white p-6 rounded-2xl shadow-soft border border-[#eaeef2]">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-[#005f2d]">support_agent</span>
                        <h4 class="font-bold text-[#171c1f]">School Contacts</h4>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">call</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Receptionist</p>
                                <p class="text-sm text-[#5c5f61]">+1 (555) 123-4567</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">mail</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Admin Office</p>
                                <p class="text-sm text-[#5c5f61]">admin@academia.edu</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-[#f6fafe]">
                            <span class="material-symbols-outlined text-[#5c5f61] mt-0.5">schedule</span>
                            <div>
                                <p class="text-xs font-semibold text-[#171c1f]">Visiting Hours</p>
                                <p class="text-sm text-[#5c5f61]">Mon-Fri, 8:00 AM - 4:00 PM</p>
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
                            <h4 class="font-bold text-[#171c1f]">Personal Information</h4>
                        </div>
                        <span class="px-2.5 py-1 bg-[#97f7ac]/30 text-[#005226] text-[10px] font-bold rounded-full uppercase tracking-wider">Verified</span>
                    </div>

                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Child Progress Summary (Mockup) --}}
                <div class="bg-white p-6 rounded-2xl border border-[#0e7a3d]/20 bg-gradient-to-r from-white to-[#f0fdf4]/20 shadow-soft">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#005f2d] filled-icon">auto_awesome</span>
                            <h4 class="font-bold text-[#171c1f]">Child Progress Summary</h4>
                        </div>
                        <span class="text-xs text-[#005f2d] font-semibold bg-[#f0fdf4] px-2 py-0.5 rounded border border-[#0e7a3d]/20">Last Updated: Today</span>
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
                                        <span class="px-2 py-[2px] rounded bg-[#97f7ac]/30 text-[#005226] text-[9px] font-bold">GPA: 3.9</span>
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
                            "Siswa terhubung aktif dengan guru dan memiliki tingkat partisipasi yang baik. Pastikan motivasi belajarnya terjaga di rumah."
                        </p>
                    </div>
                </div>

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
                <span>Profile managed by Academia IT Department.</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#005f2d] text-[18px]">verified_user</span>
                <span>Last login: Today, from Jakarta, ID.</span>
            </div>
        </div>
    </div>
</x-app-layout>