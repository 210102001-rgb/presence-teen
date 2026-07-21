<x-app-layout>
    <x-slot name="header">Import Siswa</x-slot>

    <div class="p-4 md:p-8 max-w-2xl mx-auto">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs text-secondary mb-6">
            <a href="{{ route('guru.kelas_siswa') }}" class="hover:text-primary transition-colors">Kelola Siswa</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">Import Siswa</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-on-surface">Import Siswa dari Excel</h1>
            <p class="text-sm text-secondary mt-1">Upload file Excel hasil export untuk menambahkan data siswa secara massal.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-error-container border border-error/20 rounded-xl space-y-1">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-on-error-container flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        {{-- Info Format --}}
        <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 mb-6 space-y-3">
            <p class="text-sm font-semibold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">info</span>
                Format File yang Diterima
            </p>
            <p class="text-xs text-on-surface">Gunakan file hasil <strong>Export Excel</strong> dari halaman ini. Kolom yang dibaca sistem:</p>
            <div class="overflow-x-auto">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-primary/10">
                            <th class="px-3 py-2 text-left text-primary font-semibold border border-primary/20">Kolom</th>
                            <th class="px-3 py-2 text-left text-primary font-semibold border border-primary/20">Isi</th>
                            <th class="px-3 py-2 text-left text-primary font-semibold border border-primary/20">Wajib</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        <tr><td class="px-3 py-2 border border-surface-container font-mono">A</td><td class="px-3 py-2 border border-surface-container">No (angka urut)</td><td class="px-3 py-2 border border-surface-container text-center">✓</td></tr>
                        <tr class="bg-surface-container/30"><td class="px-3 py-2 border border-surface-container font-mono">B</td><td class="px-3 py-2 border border-surface-container">Nama Siswa</td><td class="px-3 py-2 border border-surface-container text-center">✓</td></tr>
                        <tr><td class="px-3 py-2 border border-surface-container font-mono">C</td><td class="px-3 py-2 border border-surface-container">NIS</td><td class="px-3 py-2 border border-surface-container text-center">—</td></tr>
                        <tr class="bg-surface-container/30"><td class="px-3 py-2 border border-surface-container font-mono">D</td><td class="px-3 py-2 border border-surface-container">Email (unik per akun)</td><td class="px-3 py-2 border border-surface-container text-center">✓</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-secondary">Password default untuk akun baru: <span class="font-semibold text-on-surface">password</span></p>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container p-6">
            <form action="{{ route('guru.kelas_siswa.import.store') }}" method="POST"
                  enctype="multipart/form-data" class="space-y-5"
                  x-data="{ fileName: '', dragging: false }">
                @csrf

                {{-- Pilih Kelas --}}
                <div>
                    <label for="kelas_id" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                        Masukkan ke Kelas <span class="text-error">*</span>
                    </label>
                    <select name="kelas_id" id="kelas_id" required
                            class="w-full px-4 py-2.5 border border-outline-variant rounded-xl text-sm text-on-surface
                                   focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        <option value="">-- Pilih Kelas --</option>
                        @forelse($kelas as $k)
                            <option value="{{ $k->id }}" @selected(old('kelas_id') == $k->id)>
                                {{ $k->nama_kelas }} — {{ $k->mata_pelajaran }}
                            </option>
                        @empty
                            <option disabled>Belum ada kelas</option>
                        @endforelse
                    </select>
                    @error('kelas_id')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Area --}}
                <div>
                    <label class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">
                        File Excel <span class="text-error">*</span>
                    </label>
                    <label
                        class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-xl cursor-pointer transition-all"
                        :class="dragging ? 'border-primary bg-primary/5' : 'border-outline-variant bg-surface-container-low hover:bg-surface-container hover:border-primary'"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false; fileName = $event.dataTransfer.files[0]?.name; $refs.fileInput.files = $event.dataTransfer.files">
                        <input type="file" name="file_excel" accept=".xlsx,.xls"
                               x-ref="fileInput" class="hidden"
                               @change="fileName = $event.target.files[0]?.name">

                        <template x-if="!fileName">
                            <div class="flex flex-col items-center gap-2 text-secondary">
                                <span class="material-symbols-outlined text-4xl">upload_file</span>
                                <p class="text-sm font-medium">Klik atau drag & drop file di sini</p>
                                <p class="text-xs">Format: .xlsx atau .xls</p>
                            </div>
                        </template>
                        <template x-if="fileName">
                            <div class="flex flex-col items-center gap-2 text-primary">
                                <span class="material-symbols-outlined text-4xl filled-icon">check_circle</span>
                                <p class="text-sm font-semibold" x-text="fileName"></p>
                                <p class="text-xs text-secondary">Siap diproses</p>
                            </div>
                        </template>
                    </label>
                    @error('file_excel')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Warning --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <span class="material-symbols-outlined text-amber-600 text-[20px] shrink-0 mt-0.5">warning</span>
                    <div class="text-xs text-amber-800 space-y-1">
                        <p class="font-semibold">Perhatian sebelum import:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            <li>Siswa dengan email yang sudah ada akan diperbarui datanya (nama & NIS)</li>
                            <li>Siswa yang sudah terdaftar di kelas tujuan akan dilewati</li>
                            <li>Akun baru otomatis dibuat dengan password default: <span class="font-semibold">password</span></li>
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit" :disabled="!fileName"
                            class="flex-1 bg-primary text-white py-2.5 rounded-xl text-sm font-semibold
                                   hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft
                                   disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-[18px]">file_download</span>
                        Proses Import
                    </button>
                    <a href="{{ route('guru.kelas_siswa') }}"
                       class="flex-1 bg-surface-container text-on-surface py-2.5 rounded-xl text-sm font-semibold
                              hover:bg-surface-container-high transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Download Template --}}
        <div class="mt-4 text-center">
            <p class="text-xs text-secondary">
                Belum punya file? 
                <a href="{{ route('guru.kelas_siswa.export') }}" class="text-primary font-semibold hover:underline">
                    Download template dari halaman Siswa
                </a>
            </p>
        </div>

    </div>
</x-app-layout>
