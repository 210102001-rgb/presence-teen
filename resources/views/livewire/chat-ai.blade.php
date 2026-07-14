<div>
    {{-- Floating Chat Button --}}
    <button wire:click="toggleChat" 
            class="fixed bottom-20 lg:bottom-6 right-6 pb-safe w-14 h-14 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 focus:outline-none">
        <span class="material-symbols-outlined text-[28px] {{ $isOpen ? '' : 'filled-icon' }}">
            {{ $isOpen ? 'close' : 'smart_toy' }}
        </span>
    </button>

    {{-- Chat Panel --}}
    <div x-data="{ open: @entangle('isOpen') }" 
         x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-8"
         class="fixed right-6 bottom-28 lg:bottom-24 w-[90%] sm:w-[400px] max-h-[70vh] bg-white shadow-2xl rounded-2xl border border-surface-container z-50 overflow-hidden flex flex-col"
         style="display: none;">
        
        {{-- Chat Header --}}
        <div class="bg-primary p-4 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-full p-1 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px] filled-icon">smart_toy</span>
                </div>
                <div>
                    <h4 class="font-bold text-sm leading-tight">Asisten AI Presensi-Teen</h4>
                    <p class="text-[9px] text-white/80">Premium AI Intelligence</p>
                </div>
            </div>
            <button wire:click="toggleChat" class="text-white/80 hover:text-white focus:outline-none">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Chat History --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-background chat-scroll" id="chat-history-container">
            @foreach($messages as $msg)
                @if($msg['role'] === 'user')
                    <div class="flex justify-end">
                        <div class="bg-primary-container text-white p-3 rounded-2xl rounded-tr-none max-w-[85%] shadow-soft text-xs leading-relaxed">
                            <p>{{ $msg['content'] }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start items-start gap-2">
                        <div class="w-7 h-7 bg-primary text-white rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">
                            AI
                        </div>
                        <div class="bg-white border border-surface-container p-3 rounded-2xl rounded-tl-none max-w-[85%] shadow-soft text-xs leading-relaxed text-on-surface">
                            <p class="whitespace-pre-wrap">{!! nl2br(e($msg['content'])) !!}</p>
                        </div>
                    </div>
                @endif
            @endforeach

            {{-- Typing indicator --}}
            <div wire:loading wire:target="sendMessage" class="flex justify-start items-start gap-2">
                <div class="w-7 h-7 bg-primary text-white rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold">
                    AI
                </div>
                <div class="bg-white border border-surface-container p-3 rounded-2xl rounded-tl-none shadow-soft">
                    <div class="flex gap-1.5">
                        <div class="w-2 h-2 bg-[#becabc] rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-[#becabc] rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-[#becabc] rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Suggested Prompts --}}
        @if(count($messages) <= 2)
            <div class="p-3 bg-surface border-t border-surface-container shrink-0">
                <p class="text-[9px] text-secondary font-bold mb-2 uppercase tracking-wider">Saran Pertanyaan</p>
                <div class="flex flex-col gap-1.5">
                    @if(auth()->user()->role === 'orang_tua')
                        <button wire:click="selectPrompt('Bagaimana tingkat kehadiran anak saya minggu ini?')" 
                                class="text-left text-xs bg-white border border-surface-container hover:border-primary hover:text-primary p-2.5 rounded-xl transition-all flex justify-between items-center group font-medium text-on-surface">
                            <span>Bagaimana tingkat kehadiran anak saya?</span>
                            <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                        </button>
                        <button wire:click="selectPrompt('Adakah rekomendasi belajar dari AI untuk anak saya?')" 
                                class="text-left text-xs bg-white border border-surface-container hover:border-primary hover:text-primary p-2.5 rounded-xl transition-all flex justify-between items-center group font-medium text-on-surface">
                            <span>Rekomendasi belajar untuk anak?</span>
                            <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                        </button>
                    @else
                        <button wire:click="selectPrompt('Bagaimana persentase kehadiran saya sejauh ini?')" 
                                class="text-left text-xs bg-white border border-surface-container hover:border-primary hover:text-primary p-2.5 rounded-xl transition-all flex justify-between items-center group font-medium text-on-surface">
                            <span>Bagaimana persentase kehadiran saya?</span>
                            <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                        </button>
                        <button wire:click="selectPrompt('Berikan tips menjaga konsistensi belajar dari AI.')" 
                                class="text-left text-xs bg-white border border-surface-container hover:border-primary hover:text-primary p-2.5 rounded-xl transition-all flex justify-between items-center group font-medium text-on-surface">
                            <span>Tips konsistensi belajar?</span>
                            <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- Chat Input --}}
        <form wire:submit.prevent="sendMessage" class="p-3 bg-white border-t border-surface-container flex gap-2 shrink-0 items-center">
            <input wire:model="newMessage" 
                   type="text" 
                   placeholder="Tanyakan sesuatu ke AI..." 
                   wire:loading:disabled
                   class="flex-1 px-3 py-2 border border-surface-container rounded-xl text-xs text-on-surface bg-background focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all disabled:opacity-50">
            <button type="submit" 
                    wire:loading:disabled
                    class="w-8 h-8 bg-primary text-white rounded-xl flex items-center justify-center hover:bg-primary-container active:scale-95 transition-all shrink-0 focus:outline-none disabled:opacity-50">
                <span class="material-symbols-outlined text-[18px]" wire:loading.remove wire:target="sendMessage">send</span>
                <svg wire:loading wire:target="sendMessage" class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>

    {{-- Auto scroll to bottom of chat --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            const container = document.getElementById('chat-history-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
                
                Livewire.hook('morph.updated', ({ el, component }) => {
                    if (el.id === 'chat-history-container') {
                        setTimeout(() => {
                            container.scrollTop = container.scrollHeight;
                        }, 50);
                    }
                });
            }
        });
    </script>
</div>
