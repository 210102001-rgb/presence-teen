<x-app-layout>
    <x-slot name="header">Kelola Akun</x-slot>

    <div class="p-4 md:p-8 max-w-6xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-on-surface">Kelola Akun Pengguna</h1>
                <p class="text-xs text-secondary">Kelola, edit, dan hapus akun pengguna sistem</p>
            </div>
            <a href="{{ route('account.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors shadow-soft">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Akun
            </a>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-on-surface uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($users as $user)
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-secondary break-all">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if($user->role === 'super_admin') bg-primary/15 text-primary
                                        @elseif($user->role === 'guru') bg-secondary/15 text-secondary
                                        @elseif($user->role === 'siswa') bg-tertiary/15 text-tertiary
                                        @elseif($user->role === 'orang_tua') bg-error/15 text-error
                                        @endif">
                                        @if($user->role === 'super_admin') Super Admin
                                        @elseif($user->role === 'guru') Guru
                                        @elseif($user->role === 'siswa') Siswa
                                        @elseif($user->role === 'orang_tua') Orang Tua
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary">{{ $user->nis ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm space-x-2 flex flex-wrap gap-2">
                                    <a href="{{ route('account.edit', $user) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-secondary/15 text-secondary rounded-lg text-xs font-semibold hover:bg-secondary/25 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        Edit
                                    </a>
                                    @if($user->role !== 'super_admin')
                                        <a href="{{ route('account.edit-password', $user) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-tertiary/15 text-tertiary rounded-lg text-xs font-semibold hover:bg-tertiary/25 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">key</span>
                                            Password
                                        </a>
                                        <form action="{{ route('account.destroy', $user) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-error/15 text-error rounded-lg text-xs font-semibold hover:bg-error/25 transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">delete</span>
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-secondary">Akun terlindungi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-4xl text-secondary/30">people</span>
                                        <p class="text-sm text-secondary">Belum ada akun yang terdaftar</p>
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
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
