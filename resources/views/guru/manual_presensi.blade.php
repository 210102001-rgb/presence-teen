<x-app-layout>
    <x-slot name="header">Input Manual Kehadiran</x-slot>

    <div class="p-4 md:p-8 max-w-4xl mx-auto space-y-6">
        <div>
            <p class="text-primary font-semibold text-xs mb-1 uppercase tracking-widest">Manual Attendance Override</p>
            <h1 class="text-2xl font-bold text-on-surface">Input Manual Kehadiran</h1>
            <p class="text-xs text-secondary">Koreksi atau isi kehadiran siswa secara manual untuk sesi tertentu.</p>
        </div>

        @if(session('success'))
            <div class="p-4 bg-primary/10 border border-primary/20 text-primary rounded-xl text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
            <div class="px-6 py-4 bg-background border-b border-surface-container">
                <h3 class="font-bold text-sm text-on-surface">Form Koreksi Presensi</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('presensi.manual.store') }}" method="POST" class="space-y-4" x-data="{ 
                    selectedSesi: '',
                    sesiMap: {},
                    students: [],
                    init() {
                        this.sesiMap = {{ json_encode($sesi->groupBy('id')->map(function($s) {
                            return $s->first()->kelas->siswa->map(function($stud) {
                                return [
                                    'id' => $stud->id,
                                    'name' => $stud->name,
                                    'nis' => $stud->nis
                                ];
                            });
                        })) }};
                    },
                    updateStudents() {
                        this.students = this.sesiMap[this.selectedSesi] || [];
                    }
                }">
                    @csrf
                    
                    {{-- Pilih Sesi Presensi --}}
                    <div>
                        <label for="sesi_presensi_id" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Pilih Sesi Presensi</label>
                        <select name="sesi_presensi_id" id="sesi_presensi_id" x-model="selectedSesi" @change="updateStudents()"
                                class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                            <option value="">-- Pilih Sesi (Kelas - Mata Pelajaran - Tanggal) --</option>
                            @foreach($sesi as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->kelas->nama_kelas }} - {{ $s->mata_pelajaran }} ({{ \Carbon\Carbon::parse($s->created_at)->translatedFormat('d M Y, H:i') }})
                                </option>
                            @endforeach
                        </select>
                        @error('sesi_presensi_id')
                            <p class="mt-1 text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Pilih Siswa --}}
                    <div>
                        <label for="siswa_id" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Pilih Siswa</label>
                        <select name="siswa_id" id="siswa_id" 
                                class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                            <option value="">-- Pilih Siswa --</option>
                            <template x-for="student in students" :key="student.id">
                                <option :value="student.id" x-text="student.name + (student.nis ? ' (NIS: ' + student.nis + ')' : '')"></option>
                            </template>
                        </select>
                        @error('siswa_id')
                            <p class="mt-1 text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Kehadiran --}}
                    <div>
                        <label for="status" class="block text-xs font-semibold text-secondary uppercase tracking-wider mb-1.5">Status Kehadiran</label>
                        <select name="status" id="status" 
                                class="w-full rounded-xl border-surface-container focus:border-primary focus:ring focus:ring-primary/20 text-sm" required>
                            <option value="hadir">Hadir</option>
                            <option value="telat">Terlambat</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="alpha">Alpha (Tanpa Keterangan)</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-2 shadow-soft">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Presensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
