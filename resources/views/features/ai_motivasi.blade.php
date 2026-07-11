<x-app-layout>
    <x-slot name="header">AI Insights & Motivasi</x-slot>

    <div class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        {{-- Hero Bento Grid Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            {{-- AI Avatar & High-Level Insights --}}
            <div class="lg:col-span-8 bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden flex flex-col md:flex-row relative">
                <div class="absolute top-4 right-4 z-10">
                    <span class="flex items-center gap-1 bg-[#f0fdf4] text-[#005f2d] px-3 py-1 rounded-full text-[10px] font-bold border border-[#0e7a3d]/20">
                        <span class="material-symbols-outlined filled-icon text-[12px]">verified</span>
                        95% Akurasi Model AI
                    </span>
                </div>
                <div class="w-full md:w-1/3 bg-[#f6fafe] p-6 flex flex-col items-center justify-center text-center border-r border-[#eaeef2]">
                    <div class="w-28 h-28 rounded-full border-4 border-[#97f7ac] p-1 mb-4 flex items-center justify-center bg-[#0e7a3d]/10">
                        <span class="material-symbols-outlined text-[64px] text-[#005f2d]">psychology</span>
                    </div>
                    <h3 class="font-bold text-sm text-[#005f2d]">AcademAI Engine</h3>
                    <p class="text-[10px] text-[#5c5f61] mt-1 leading-normal">Mesin rekomendasi motivasi & belajar presisi</p>
                </div>
                <div class="w-full md:w-2/3 p-6 flex flex-col justify-between">
                    <div class="space-y-4">
                        <p class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-widest">Analisis Hari Ini</p>
                        <h2 class="text-lg font-bold text-[#171c1f] leading-snug">Siswa saat ini beraktivitas pada performa dan konsistensi terbaiknya.</h2>
                        <blockquote class="italic text-[#5c5f61] text-xs border-l-4 border-[#005f2d] pl-4 py-2 bg-[#f6fafe] rounded-r-xl">
                            "Ketekunan adalah kunci keberhasilan. Ahmad menunjukkan konsistensi yang luar biasa minggu ini di mata pelajaran Matematika."
                        </blockquote>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-4">
                        <div class="px-4 py-2 bg-[#f0fdf4] rounded-xl flex items-center gap-2 border border-[#0e7a3d]/10">
                            <span class="material-symbols-outlined text-[#005f2d] text-[18px]">trending_up</span>
                            <div>
                                <p class="text-[8px] text-[#5c5f61] font-bold uppercase">Klasifikasi</p>
                                <p class="text-[10px] font-bold text-[#005f2d]">Sangat Aktif</p>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-[#f0fdf4] rounded-xl flex items-center gap-2 border border-[#0e7a3d]/10">
                            <span class="material-symbols-outlined text-[#0e7a3d] text-[18px]">security</span>
                            <div>
                                <p class="text-[8px] text-[#5c5f61] font-bold uppercase">Tingkat Risiko</p>
                                <p class="text-[10px] font-bold text-[#005f2d]">Rendah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Achievement Badge --}}
            <div class="lg:col-span-4 bg-white rounded-2xl shadow-soft border border-[#eaeef2] p-6 flex flex-col items-center justify-center text-center">
                <p class="text-[9px] text-[#5c5f61] font-bold uppercase tracking-widest mb-4">Lencana Terbaru</p>
                <div class="w-16 h-16 bg-[#f0fdf4] rounded-full border border-[#0e7a3d]/20 flex items-center justify-center text-[#0e7a3d] mb-4">
                    <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                </div>
                <h3 class="font-bold text-sm text-[#171c1f]">Consistency Master</h3>
                <p class="text-xs text-[#5c5f61] mt-2 px-2 leading-relaxed">Siswa telah mengumpulkan semua tugas tepat waktu selama 30 hari berturut-turut.</p>
                <button class="mt-6 w-full py-2.5 bg-[#005f2d] hover:bg-[#0e7a3d] text-white rounded-xl text-xs font-bold transition-all active:scale-95 shadow-soft">
                    Buka Ruang Penghargaan
                </button>
            </div>
        </div>

        {{-- Recommendations Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Recommendations for Parents --}}
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="bg-[#f6fafe] px-6 py-4 border-b border-[#eaeef2] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#005f2d]">family_restroom</span>
                        <h4 class="font-bold text-sm text-[#171c1f]">Panduan untuk Orang Tua</h4>
                    </div>
                    <span class="px-2.5 py-0.5 bg-[#f0fdf4] border border-[#0e7a3d]/20 text-[#005f2d] rounded-full text-[9px] font-bold">4 TINDAKAN AI</span>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex gap-4 p-4 hover:bg-[#f6fafe] rounded-xl border border-transparent hover:border-[#eaeef2] transition-all">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                            <span class="material-symbols-outlined text-[#5c5f61] text-[20px]">menu_book</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-[#171c1f]">Dukung Minat Eksakta</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 leading-relaxed">Ahmad menunjukkan minat yang meningkat pada Matematika. Coba berikan buku materi pengayaan atau ajak berdiskusi santai di akhir pekan.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 p-4 hover:bg-[#f6fafe] rounded-xl border border-transparent hover:border-[#eaeef2] transition-all">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                            <span class="material-symbols-outlined text-[#5c5f61] text-[20px]">forum</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-[#171c1f]">Diskusikan Minat Karir</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 leading-relaxed">Skor analitisnya menunjukkan kecenderungan kuat di bidang Rekayasa Teknologi / Komputer. Tanyakan minat karirnya ke depan.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recommendations for Student --}}
            <div class="bg-white rounded-2xl shadow-soft border border-[#eaeef2] overflow-hidden">
                <div class="bg-[#f6fafe] px-6 py-4 border-b border-[#eaeef2] flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#005f2d]">person</span>
                        <h4 class="font-bold text-sm text-[#171c1f]">Misi Mingguan Siswa</h4>
                    </div>
                    <span class="px-2.5 py-0.5 bg-[#005f2d] text-white rounded-full text-[9px] font-bold">SELANJUTNYA</span>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex gap-4 p-4 bg-[#f0fdf4] rounded-xl border border-[#0e7a3d]/20 relative">
                        <div class="w-10 h-10 rounded-full bg-[#005f2d]/10 text-[#005f2d] flex items-center justify-center shrink-0 border border-[#0e7a3d]/20">
                            <span class="material-symbols-outlined text-[20px]">fitness_center</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-[#005226]">Selesaikan Quiz Eksponensial</h5>
                            <p class="text-xs text-[#3f493f] mt-1 leading-relaxed">Ada latihan tambahan opsional yang tersedia. Menyelesaikannya akan menaikkan indeks keaktifan belajarmu sebesar 5%.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 p-4 hover:bg-[#f6fafe] rounded-xl border border-transparent hover:border-[#eaeef2] transition-all">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                            <span class="material-symbols-outlined text-[#5c5f61] text-[20px]">explore</span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-[#171c1f]">Eksplorasi Modul Logaritma</h5>
                            <p class="text-xs text-[#5c5f61] mt-1 leading-relaxed">Pelajari materi baru tentang logaritma yang telah diunggah guru di halaman Materi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
