<x-app-layout>
    <x-slot name="header">Kelola Guru</x-slot>

    <div class="p-4 md:p-8 max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Kelola Guru</h1>
            <p class="text-xs text-secondary">Kelola dan edit data akun guru</p>
        </div>

        @if(session('success'))
            <div x-data x-init="$dispatch('toast', { type: 'success', message: '{{ session('success') }}' })"></div>
        @endif

        @if(session('error'))
            <div x-data x-init="$dispatch('toast', { type: 'error', message: '{{ session('error') }}' })"></div>
        @endif

        <div class="bg-white rounded-2xl shadow-soft border border-surface-container overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-surface-container bg-surface-container">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Jumlah Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($gurus as $guru)
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">{{ $guru->name }}</td>
                                <td class="px-6 py-4 text-sm text-secondary break-all">{{ $guru->email }}</td>
                                <td class="px-6 py-4 text-sm text-secondary">
                                    {{ $guru->mata_pelajaran ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-secondary/15 text-secondary">
                                        <span class="material-symbols-outlined text-[14px]">class</span>
                                        {{ $guru->jumlah_kelas }} kelas
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm flex flex-wrap gap-2">
                                    <a href="{{ route('guru.kelola.edit', $guru) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary/15 text-secondary rounded-lg text-xs font-semibold hover:bg-secondary/25 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        Edit
                                    </a>
                                    <a href="{{ route('guru.kelola.edit-password', $guru) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-tertiary/15 text-tertiary rounded-lg text-xs font-semibold hover:bg-tertiary/25 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">key</span>
                                        Password
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-4xl text-secondary/30">school</span>
                                        <p class="text-sm text-secondary">Belum ada akun guru yang terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center">
            {{ $gurus->links() }}
        </div>
    </div>
</x-app-layout>
