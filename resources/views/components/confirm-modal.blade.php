{{-- SweetAlert-style Confirm Modal --}}
<div
    x-data="{
        visible: false,
        title: '',
        description: '',
        type: 'danger',
        confirmText: '',
        onConfirm: null,
        show(opts) {
            this.title = opts.title || '';
            this.description = opts.description || '';
            this.type = opts.type || 'danger';
            this.confirmText = opts.confirmText || 'Ya, Lanjutkan';
            this.onConfirm = opts.onConfirm || null;
            this.visible = true;
        },
        confirm() {
            this.visible = false;
            if (this.onConfirm) this.onConfirm();
        },
        cancel() {
            this.visible = false;
        }
    }"
    x-on:confirm.window="show($event.detail)"
    class="fixed inset-0 z-[90] flex items-center justify-center p-4"
    style="display: none;"
    x-show="visible"
>
    {{-- Backdrop --}}
    <div
        x-show="visible"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 bg-black/50"
        @click="cancel()">
    </div>

    {{-- Panel --}}
    <div
        x-show="visible"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150 transform"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden"
        @click.away="cancel()"
        @keydown.escape.window="cancel()"
    >
        {{-- Top accent bar --}}
        <div class="h-1 w-full"
             :class="{
                 'bg-[#ba1a1a]': type === 'danger',
                 'bg-[#2563eb]': type === 'info',
                 'bg-[#ea580c]': type === 'warning'
             }">
        </div>

        <div class="p-6 text-center">
            {{-- Icon --}}
            <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center"
                 :class="{
                     'bg-[#ffdad6]': type === 'danger',
                     'bg-[#dbeafe]': type === 'info',
                     'bg-[#fff7ed]': type === 'warning'
                 }">
                <span class="material-symbols-outlined text-[32px] filled-icon"
                      :class="{
                          'text-[#ba1a1a]': type === 'danger',
                          'text-[#2563eb]': type === 'info',
                          'text-[#ea580c]': type === 'warning'
                      }"
                      x-text="{
                          danger: 'delete',
                          info: 'info',
                          warning: 'warning'
                      }[type]">
                </span>
            </div>

            {{-- Title --}}
            <h3 class="text-lg font-bold text-[#171c1f] mb-2" x-text="title"></h3>

            {{-- Description --}}
            <p class="text-sm text-[#5c5f61] leading-relaxed" x-text="description"></p>
        </div>

        {{-- Actions --}}
        <div class="px-6 pb-6 flex gap-3">
            <button @click="cancel()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-[#becabc] text-sm font-semibold text-[#5c5f61] hover:bg-[#f0f4f8] active:scale-[0.98] transition-all">
                Batal
            </button>
            <button @click="confirm()"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white active:scale-[0.98] transition-all"
                    :class="{
                        'bg-[#ba1a1a] hover:bg-[#93000a]': type === 'danger',
                        'bg-[#2563eb] hover:bg-[#1d4ed8]': type === 'info',
                        'bg-[#ea580c] hover:bg-[#c2410c]': type === 'warning'
                    }"
                    x-text="confirmText">
            </button>
        </div>
    </div>
</div>
