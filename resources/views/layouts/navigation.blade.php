<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-indigo-600 font-black text-sm">PT</span>
                    </div>
                    <span class="text-white font-bold text-lg">Presence-Teen</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-1">
                    @php
                        $role = Auth::user()->role;
                    @endphp

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white/80 hover:text-white">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    @if ($role === 'siswa')
                        <x-nav-link :href="route('presensi.scan')" :active="request()->routeIs('presensi.scan')" class="text-white/80 hover:text-white">
                            {{ __('Scan Presensi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tugas.index')" :active="request()->routeIs('tugas.index')" class="text-white/80 hover:text-white">
                            {{ __('Tugas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('materi.index')" :active="request()->routeIs('materi.*')" class="text-white/80 hover:text-white">
                            {{ __('Materi') }}
                        </x-nav-link>
                    @elseif ($role === 'guru')
                        <x-nav-link :href="route('presensi.guru')" :active="request()->routeIs('presensi.guru')" class="text-white/80 hover:text-white">
                            {{ __('QR Presensi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('materi.create')" :active="request()->routeIs('materi.create')" class="text-white/80 hover:text-white">
                            {{ __('Upload Materi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tugas.index')" :active="request()->routeIs('tugas.index')" class="text-white/80 hover:text-white">
                            {{ __('Tugas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="text-white/80 hover:text-white">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @elseif ($role === 'orang_tua')
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="text-white/80 hover:text-white">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-white/90 hover:text-white bg-white/10 hover:bg-white/20 rounded-lg transition duration-150 ease-in-out">
                            <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold text-white mr-2">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white/80 hover:text-white hover:bg-white/10">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            @if ($role === 'siswa')
                <x-responsive-nav-link :href="route('presensi.scan')" :active="request()->routeIs('presensi.scan')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Scan Presensi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tugas.index')" :active="request()->routeIs('tugas.index')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Tugas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('materi.index')" :active="request()->routeIs('materi.*')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Materi') }}
                </x-responsive-nav-link>
            @elseif ($role === 'guru')
                <x-responsive-nav-link :href="route('presensi.guru')" :active="request()->routeIs('presensi.guru')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('QR Presensi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('materi.create')" :active="request()->routeIs('materi.create')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Upload Materi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tugas.index')" :active="request()->routeIs('tugas.index')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Tugas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @elseif ($role === 'orang_tua')
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-3 border-t border-white/10">
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="ms-3">
                    <div class="font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-white/60">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white/80 hover:text-white hover:bg-white/10">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-white/80 hover:text-white hover:bg-white/10">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
