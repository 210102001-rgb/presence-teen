<x-app-layout>
    <x-slot name="header">Prediksi Absensi AI</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Dashboard Header / AI Insight --}}
        <div class="bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-2xl p-6 shadow-soft flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[80px] text-[#0e7a3d]">auto_awesome</span>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#005f2d]/10 text-[#005f2d] rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined filled-icon">auto_awesome</span>
                </div>
                <div>
                    <h3 class="font-bold text-[#005f2d] text-sm mb-1">AI Insight: Prediksi Absensi & Risiko</h3>
                    <p class="text-xs text-[#3f493f] leading-relaxed max-w-2xl">
                        Berdasarkan analisis riwayat kehadiran semester ganjil, siswa diprediksi memiliki tingkat kehadiran yang sangat stabil di angka 97.8% untuk sisa semester ini.
                    </p>
                </div>
            </div>
            <button class="shrink-0 bg-[#005f2d] text-white px-5 py-2.5 rounded-xl text-xs font-semibold hover:bg-[#0e7a3d] transition-all shadow-soft z-10 self-stretch md:self-auto text-center">
                Jadwalkan Konsultasi
            </button>
        </div>

        {{-- Bento Grid Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            {{-- Key Prediction Card 1 --}}
            <div class="md:col-span-3 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-[#005f2d] bg-[#f0fdf4] p-2.5 rounded-xl border border-[#0e7a3d]/20">event_available</span>
                    <span class="text-[9px] text-[#005f2d] font-bold bg-[#f0fdf4] px-2.5 py-[2px] rounded-full">+1.2%</span>
                </div>
                <div>
                    <p class="text-[#5c5f61] font-bold text-[9px] uppercase tracking-wider">Prediksi Kehadiran</p>
                    <h4 class="text-3xl font-bold text-[#171c1f] mt-1">97.8%</h4>
                </div>
                <p class="text-[10px] text-[#5c5f61] mt-3">Target minimal sekolah: 95.0%</p>
            </div>

            {{-- Key Prediction Card 2 --}}
            <div class="md:col-span-3 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <span class="material-symbols-outlined text-amber-600 bg-amber-50 p-2.5 rounded-xl border border-amber-200">warning</span>
                    <span class="text-[9px] text-amber-700 font-bold bg-amber-100 px-2.5 py-[2px] rounded-full">Rendah</span>
                </div>
                <div>
                    <p class="text-[#5c5f61] font-bold text-[9px] uppercase tracking-wider">Prediksi Alpha</p>
                    <h4 class="text-3xl font-bold text-[#171c1f] mt-1">0 Hari</h4>
                </div>
                <p class="text-[10px] text-[#5c5f61] mt-3">Estimasi hingga akhir semester</p>
            </div>

            {{-- Confidence Score --}}
            <div class="md:col-span-6 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between">
                <div class="flex justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-sm text-[#171c1f]">Tingkat Akurasi Model AI</h4>
                        <p class="text-[10px] text-[#5c5f61]">Reliabilitas analisis prediksi saat ini</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold text-[#005f2d]">92%</span>
                        <p class="text-[9px] text-[#005f2d] font-bold uppercase">Sangat Tinggi</p>
                    </div>
                </div>
                <div class="w-full bg-[#f6fafe] rounded-full h-3 border border-[#eaeef2] overflow-hidden">
                    <div class="h-full bg-[#005f2d] rounded-full" style="width: 92%;"></div>
                </div>
                <p class="text-[10px] text-[#5c5f61] mt-2">Dihitung berdasarkan 15 parameter historis siswa.</p>
            </div>

            {{-- Trend Chart Container (Col-span 8) --}}
            <div class="md:col-span-8 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between min-h-[300px]">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-sm text-[#171c1f]">Prediksi Tren Kehadiran Semester Ini</h4>
                    <div class="flex gap-4">
                        <span class="flex items-center gap-1.5 text-xs text-[#5c5f61]"><span class="w-2.5 h-2.5 rounded-full bg-[#005f2d]"></span> Riwayat Asli</span>
                        <span class="flex items-center gap-1.5 text-xs text-[#5c5f61]"><span class="w-2.5 h-2.5 rounded-full bg-[#495362] border border-[#005f2d] border-dashed"></span> Prediksi AI</span>
                    </div>
                </div>
                <div class="h-44 w-full flex items-end gap-6 pt-4">
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-[#f6fafe] rounded-t-xl h-[90%] relative border border-[#eaeef2]">
                            <div class="absolute bottom-0 w-full bg-[#005f2d] rounded-t-xl h-[95%]"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Juli</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-[#f6fafe] rounded-t-xl h-[90%] relative border border-[#eaeef2]">
                            <div class="absolute bottom-0 w-full bg-[#005f2d] rounded-t-xl h-[92%]"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">Agustus</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-[#f6fafe] rounded-t-xl h-[90%] relative border border-[#eaeef2]">
                            <div class="absolute bottom-0 w-full bg-[#005f2d] rounded-t-xl h-[98%]"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">September</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-[#f6fafe] rounded-t-xl h-[90%] relative border border-[#eaeef2]">
                            <div class="absolute bottom-0 w-full bg-[#495362] border-2 border-dashed border-[#005f2d] rounded-t-xl h-[96%]"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#005f2d]">Oktober</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-[#f6fafe] rounded-t-xl h-[90%] relative border border-[#eaeef2]">
                            <div class="absolute bottom-0 w-full bg-gray-300 border-2 border-dashed border-gray-400 rounded-t-xl h-[95%]"></div>
                        </div>
                        <span class="text-[10px] font-bold text-[#5c5f61]">November</span>
                    </div>
                </div>
            </div>

            {{-- Prediction Factors (Col-span 4) --}}
            <div class="md:col-span-4 bg-white p-6 rounded-2xl border border-[#eaeef2] shadow-soft flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-sm text-[#171c1f] mb-4">Faktor Kunci Prediksi</h4>
                    <ul class="space-y-4">
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[#005f2d] mt-0.5">sentiment_very_satisfied</span>
                            <div>
                                <h5 class="text-xs font-bold text-[#171c1f]">Keaktifan Harian Tinggi</h5>
                                <p class="text-[10px] text-[#5c5f61] mt-0.5">Siswa sering mengakses portal pembelajaran secara teratur.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[#005f2d] mt-0.5">verified_user</span>
                            <div>
                                <h5 class="text-xs font-bold text-[#171c1f]">Validasi Perangkat Aman</h5>
                                <p class="text-[10px] text-[#5c5f61] mt-0.5">Tidak pernah tercatat adanya kecurangan atau ganti perangkat abnormal.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-[#495362] mt-0.5">info</span>
                            <div>
                                <h5 class="text-xs font-bold text-[#171c1f]">Toleransi Telat Terjaga</h5>
                                <p class="text-[10px] text-[#5c5f61] mt-0.5">Tingkat keterlambatan berada jauh di bawah ambang batas guru.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
