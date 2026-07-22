<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Presence-Teen') }} — @isset($header){{ $header }}@else Dashboard @endif</title>
    <link rel="icon" type="image/png" href="{{ asset('smansa.png') }}">

    <!-- Google Fonts: Inter + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f6fafe; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .filled-icon { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .shadow-soft { box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.02); }
        .ai-glow { background: #f0fdf4; border: 1px solid rgba(14,122,61,0.15); }
        .ai-border {
            border: 1px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(to right, #0e7a3d, #495362) border-box;
        }
        .bento-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .bento-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px rgba(0,0,0,0.07); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #dfe3e7; border-radius: 10px; }

        /* Loading screen */
        .page-loader {
            position: fixed; inset: 0; z-index: [9999]; background: #f6fafe;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        .page-loader.loaded { opacity: 0; visibility: hidden; pointer-events: none; }
        .page-loader img { animation: loaderPulse 1.5s ease-in-out infinite; }
        @keyframes loaderPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.08); opacity: 0.7; }
        }
        .page-loader .loader-dot {
            width: 6px; height: 6px; border-radius: 50%; background: #005f2d;
            animation: loaderBounce 1.2s ease-in-out infinite;
        }
        .page-loader .loader-dot:nth-child(2) { animation-delay: 0.15s; }
        .page-loader .loader-dot:nth-child(3) { animation-delay: 0.3s; }
        @keyframes loaderBounce {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .page-loader img { animation: none; }
            .page-loader .loader-dot { animation: none; opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="text-[#171c1f] antialiased" x-data="{ mobileSidebarOpen: false }">

    {{-- Full-Page Loading Screen --}}
    <div class="page-loader" id="page-loader">
        <img src="{{ asset('smansa.png') }}" alt="Loading" class="w-20 h-20 mb-5 rounded-2xl shadow-lg">
        <div class="flex gap-2">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>
    </div>

    {{-- Toast Notifications --}}
    <x-toast position="top-right" />

    {{-- Confirm Modal --}}
    <x-confirm-modal />

    {{-- Mobile Sidebar Backdrop --}}
    <div x-show="mobileSidebarOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         @click="mobileSidebarOpen = false"
         style="display: none;">
    </div>

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Top Header Bar --}}
    <header class="fixed top-0 right-0 w-full lg:w-[calc(100%-16rem)] h-16 bg-surface shadow-sm flex justify-between items-center px-4 md:px-10 z-30 border-b border-surface-container">
        <div class="flex items-center gap-3">
            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="p-2 text-on-surface-variant hover:text-primary lg:hidden rounded-lg transition-colors focus:outline-none">
                <span class="material-symbols-outlined">menu</span>
            </button>
            @isset($header)
                <div class="font-semibold text-lg lg:text-xl text-primary">{{ $header }}</div>
            @endisset
        </div>
        <div class="flex items-center gap-5">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative p-1 text-on-surface-variant hover:text-primary transition-colors flex items-center">
                    <span class="material-symbols-outlined">notifications</span>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-error rounded-full ring-2 ring-white"></span>
                    @endif
                </button>
                <div x-show="open" @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-72 bg-white rounded-xl border border-surface-container shadow-lg z-50 py-3" style="display: none;">
                    <div class="px-4 pb-2 border-b border-surface-container flex justify-between items-center">
                        <span class="text-xs font-bold text-on-surface">Notifikasi</span>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <a href="#" onclick="event.preventDefault(); document.getElementById('mark-all-read').submit();" class="text-[10px] text-primary hover:underline font-semibold">Tandai dibaca</a>
                            <form id="mark-all-read" action="{{ route('notifications.markAllRead') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @endif
                    </div>
                    <div class="max-h-64 overflow-y-auto divide-y divide-surface-container">
                        @forelse(Auth::user()->notifications()->take(5)->get() as $notification)
                            <div class="px-4 py-2.5 hover:bg-surface-container-low transition-colors text-xs {{ $notification->read_at ? 'opacity-70' : 'bg-primary/5 font-medium' }}">
                                <p class="text-on-surface leading-normal">
                                    @if(isset($notification->data['type']) && $notification->data['type'] === 'pengumuman')
                                        📢 <span class="font-bold text-primary">{{ $notification->data['judul'] }}</span> ({{ $notification->data['kategori'] }}) - {{ $notification->data['message'] }}
                                    @elseif(isset($notification->data['siswa']))
                                        Anak Anda, <span class="font-bold">{{ $notification->data['siswa'] }}</span>, tercatat <span class="font-bold text-primary">{{ $notification->data['status'] }}</span> di kelas {{ $notification->data['mata_pelajaran'] }}.
                                    @else
                                        {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                                    @endif
                                </p>
                                <span class="text-[10px] text-secondary block mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="px-4 py-4 text-xs text-secondary text-center">Belum ada notifikasi baru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-white text-sm font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-medium text-on-surface hidden md:block">{{ Auth::user()->name }}</span>
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="lg:ml-64 ml-0 pt-16 min-h-screen">
        {{ $slot }}
    </main>

    {{-- Mobile Bottom Navigation --}}
    <x-mobile-bottom-nav />

    @livewire('chat-ai')
    @livewireScripts

    {{-- Alpine.js Global Stores --}}
    <script>
        document.addEventListener('alpine:init', () => {

            // Toast Store
            Alpine.store('toasts', { toasts: [], counter: 0 });

            Alpine.data('toastStore', () => ({
                get toasts() { return Alpine.store('toasts').toasts; },
                addToast({ type = 'success', title = '', message = '', duration = 5000 }) {
                    const id = ++Alpine.store('toasts').counter;
                    const toast = { id, type, title, message, visible: true, progress: 100 };
                    Alpine.store('toasts').toasts.push(toast);

                    // Auto-dismiss with progress
                    const interval = setInterval(() => {
                        toast.progress -= (100 / (duration / 50));
                        if (toast.progress <= 0) {
                            clearInterval(interval);
                            this.removeToast(id);
                        }
                    }, 50);

                    // Auto-remove after duration
                    setTimeout(() => this.removeToast(id), duration);
                },
                removeToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) {
                        toast.visible = false;
                        setTimeout(() => {
                            Alpine.store('toasts').toasts = Alpine.store('toasts').toasts.filter(t => t.id !== id);
                        }, 300);
                    }
                }
            }));

            // Confirm Store
            Alpine.data('confirmStore', () => ({
                visible: false,
                title: '',
                description: '',
                type: 'danger',
                confirmText: '',
                resolvePromise: null,
                showConfirm({ title, description, type = 'danger', confirmText = '' }) {
                    this.title = title;
                    this.description = description;
                    this.type = type;
                    this.confirmText = confirmText;
                    this.visible = true;
                    return new Promise(resolve => { this.resolvePromise = resolve; });
                },
                confirm() {
                    this.visible = false;
                    if (this.resolvePromise) this.resolvePromise(true);
                },
                cancel() {
                    this.visible = false;
                    if (this.resolvePromise) this.resolvePromise(false);
                }
            }));
        });

        // Page loader dismiss
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('page-loader')?.classList.add('loaded');
            }, 80);
        });
    </script>

    @stack('scripts')
</body>
</html>
